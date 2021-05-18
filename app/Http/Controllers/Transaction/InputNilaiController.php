<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranEkskul;
use App\Models\Siswa;
use Illuminate\Http\Request;
use stdClass;

use function App\Helpers\data_table;
use function App\Helpers\data_table_total;
use Illuminate\Support\Facades\DB;

class InputNilaiController extends Controller
{
    private $data;
    private $result;

    private function _set_result()
    {
        $this->result = new stdClass();
        $this->result->status = false;
        $this->result->message = '';
        $this->result->data = new stdClass();
    }

    public function __construct()
    {
        $this->_set_result();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = "Menu Input Nilai";
        
        // $ekskuls = DB::table('ekskul')
        //     ->select('ekskul.id','ekskul.nama_ekskul', 'jadwal_ekskul.hari', 'jadwal_ekskul.tempat', 'pelatih.nama as nama_pelatih')
        //     ->join('jadwal_ekskul', 'ekskul.id', '=', 'jadwal_ekskul.id_ekskul')
        //     ->join('pelatih', 'jadwal_ekskul.id_pelatih', '=', 'pelatih.id')
        //     ->get();

        return view(
            'Transaction.InputNilai',
            ['pages' => $pages]
        );
    }

    public function read(Request $request){
        $select = array(
            'pendaftaran_ekskul.id as id_pendaftaran',
            'siswa.nama as nama_siswa',
            'ekskul.nama_ekskul as nama_ekskul',
            'pembina.nama as nama_pembina',
            'pelatih.nama as nama_pelatih',
            'pendaftaran_ekskul.nilai as nilai_ekskul_wajib',
            'pendaftaran_ekskul.nilai_opt as nilai_ekskul_optional',
            'siswa.id as id_siswa',
            'siswa.nis',
            'siswa.kelas',
            'siswa.alamat',
            'siswa.tempat_lahir',
            'siswa.jenis_kelamin',
            'siswa.no_telp',
            'siswa.tanggal_lahir',
            'pendaftaran_ekskul.id_ekskul',
            'pendaftaran_ekskul.id_ekskul_opt',
            'siswa.gen_foto',
            'ekskul_2.nama_ekskul as nama_ekskul_opt',
        );
        $from = 'pendaftaran_ekskul';
        $where = null;
        $join = array(
            array('ekskul', 'pendaftaran_ekskul.id_ekskul', '=', 'ekskul.id'),
            array('siswa', 'pendaftaran_ekskul.id_siswa', '=', 'siswa.id'),
            array('pembina', 'ekskul.id_pembina', '=', 'pembina.id', 'left'),
            array('jadwal_ekskul', 'ekskul.id', '=', 'jadwal_ekskul.id_ekskul', 'left'),
            array('pelatih', 'jadwal_ekskul.id_pelatih', '=', 'pelatih.id', 'left'),
            array('ekskul as ekskul_2', 'pendaftaran_ekskul.id_ekskul_opt', '=', 'ekskul_2.id', 'left'),
        );
        
        $this->result->status = true;
        $this->result->draw = $request->draw;
        $this->result->data = data_table($request, $select, $from ,$where , $join);
        $this->result->recordsTotal = data_table_total($request, $select, $from,false,$where , $join)->count();
        $this->result->recordsFiltered = data_table_total($request, $select, $from,true,$where , $join)->count();

        return response()->json($this->result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $oldPendaftaran = $this->_get_pendaftaran_already_exist_by_id($request->id_pendaftaran);
        
        try {
            if($request->tipe_nilai == 1)
                $oldPendaftaran->nilai = $request->input_nilai;

            if($request->tipe_nilai == 2)
                $oldPendaftaran->nilai_opt = $request->input_nilai;
                
            $oldPendaftaran->save();

            DB::commit();
            $this->result->status = true;
            $this->result->message = 'Data berhasil disimpan.';
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->result->status = false;
            $this->result->message = 'Data gagal disimpan. ' . $th->getMessage();
        }

        return response()->json($this->result);
    }

    public function store_nilai_opt(Request $request)
    {
        DB::beginTransaction();

        $oldPendaftaran = $this->_get_pendaftaran_already_exist_by_id($request->id_pendaftaran);

        try {
            $oldPendaftaran->nilai_opt = $request->input_nilai;
            $oldPendaftaran->save();

            DB::commit();
            $this->result->status = true;
            $this->result->message = 'Data berhasil disimpan.';
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->result->status = false;
            $this->result->message = 'Data gagal disimpan. ' . $th->getMessage();
        }

        return response()->json($this->result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function _get_siswa_by_nis($nis){
        $siswa = Siswa::where('nis', '=', $nis)->first();
        return $siswa;
    }

    private function _get_pendaftaran_already_exist_by_id($id_pendaftaran){
        $pendaftaran = PendaftaranEkskul::where('id', '=', $id_pendaftaran)->first();
        return $pendaftaran;
    }

    private function _get_pendaftaran_already_exist($id_siswa, $id_ekskul){
        $pendaftaran = PendaftaranEkskul::where([['id_siswa', '=', $id_siswa], ['id_ekskul', '=', $id_ekskul]])->first();
        return $pendaftaran;
    }
}
