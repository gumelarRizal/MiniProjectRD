<?php

namespace App\Http\Controllers\Transaction;

// use App\Helpers\DbHelper;
use App\Http\Controllers\Controller;
use App\Models\PendaftaranEkskul;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use stdClass;

use function App\Helpers\data_table;
use function App\Helpers\data_table_total;

class PendaftaranEkskulController extends Controller
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

    public function index()
    {
        $pages = "Menu Pendaftaran Ekskul";
        
        $ekskuls = DB::table('ekskul')
            ->select('ekskul.id','ekskul.nama_ekskul', 'jadwal_ekskul.hari', 'jadwal_ekskul.tempat', 'pelatih.nama as nama_pelatih')
            ->join('jadwal_ekskul', 'ekskul.id', '=', 'jadwal_ekskul.id_ekskul')
            ->join('pelatih', 'jadwal_ekskul.id_pelatih', '=', 'pelatih.id')
            ->where('category', '=', '1')
            ->get();

        $ekskulsOpt = DB::table('ekskul')
            ->select('ekskul.id','ekskul.nama_ekskul', 'jadwal_ekskul.hari', 'jadwal_ekskul.tempat', 'pelatih.nama as nama_pelatih')
            ->join('jadwal_ekskul', 'ekskul.id', '=', 'jadwal_ekskul.id_ekskul')
            ->join('pelatih', 'jadwal_ekskul.id_pelatih', '=', 'pelatih.id')
            ->where('category', '=', '0')
            ->get();

        return view(
            'Transaction.PendaftaranEkskul',
            ['pages' => $pages, 'ekskuls'=>$ekskuls, 'ekskulsOpt'=>$ekskulsOpt]
        );
    }

    public function read(Request $request){
        $select = array(
            'pendaftaran_ekskul.id as id_pendaftaran',
            'siswa.nama as nama_siswa',
            'ekskul.nama_ekskul as nama_ekskul',
            'pembina.nama as nama_pembina',
            'pelatih.nama as nama_pelatih',
            'pendaftaran_ekskul.nilai as nilai',
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

    public function daftar(Request $request)
    {
        $oldDataSiswa = $this->_get_siswa_by_nis($request->daftar_nis);
        $oldPendaftaran = $this->_get_pendaftaran_already_exist($oldDataSiswa->id, $request->daftar_ekskul);
        if($oldPendaftaran){
            $this->result->status = false;
            $this->result->message = 'Siswa ini telah mendaftar diekskul yang dituju. ';
            return response()->json($this->result);
        }

        if($oldDataSiswa){
            return $this->update_daftar($request);
        }else{

            DB::beginTransaction();
            try {

                $imageName = null;
                $oriImageName = null;

                if(!is_null($request->image)){
                    $imageName = time().'.'.$request->image->extension(); 
                    $oriImageName = $request->image->getClientOriginalName();
                    $request->image->move(public_path('images'), $imageName);
                }

                

                if(!$oldDataSiswa){
                    $siswa = new Siswa();
                    $siswa->nis = $request->daftar_nis;
                    $siswa->nama = $request->daftar_nama;
                    $siswa->kelas = $request->daftar_kelas;
                    $siswa->alamat = $request->daftar_alamat;
                    $siswa->tempat_lahir = $request->daftar_tempat_lahir;
                    $siswa->jenis_kelamin = $request->daftar_jk;
                    $siswa->tanggal_lahir = $request->daftar_tgl_lahir;
                    $siswa->no_telp = $request->daftar_no_telp;
                    $siswa->ori_foto = $oriImageName;
                    $siswa->gen_foto = $imageName;
                    $siswa->save();
                }else{
                    
                    $this->update_daftar($request);
                    // $oldDataSiswa->nis = $request->daftar_nis;
                    // $oldDataSiswa->nama = $request->daftar_nama;
                    // $oldDataSiswa->kelas = $request->daftar_kelas;
                    // $oldDataSiswa->alamat = $request->daftar_alamat;
                    // $oldDataSiswa->tempat_lahir = $request->daftar_tempat_lahir;
                    // $oldDataSiswa->jenis_kelamin = $request->daftar_jk;
                    // $oldDataSiswa->tanggal_lahir = $request->daftar_tgl_lahir;
                    // $oldDataSiswa->no_telp = $request->daftar_no_telp;
                    // $oldDataSiswa->ori_foto = $oriImageName;
                    // $oldDataSiswa->gen_foto = $imageName;
                    // $oldDataSiswa->save();
                }

                // $daftar_ekskul = new PendaftaranEkskul();
                // $daftar_ekskul->id_siswa = (!$oldDataSiswa) ? $oldDataSiswa->id : $siswa->id;
                // $daftar_ekskul->id_ekskul = $request->daftar_ekskul; 
                // $daftar_ekskul->id_ekskul_opt = $request->daftar_ekskul_opt; 
                // $daftar_ekskul->save();

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
    }

    public function update_daftar(Request $request)
    {
        DB::beginTransaction();
        try {

            $oldDataSiswa = $this->_get_siswa_by_nis($request->daftar_nis);
            $imageName = null;
            $oriImageName = null;
            if(!is_null($request->image)){
                $imageName = time().'.'.$request->image->extension(); 
                $oriImageName = $request->image->getClientOriginalName();
            }else{
                $imageName = $oldDataSiswa->gen_foto;
                $oriImageName = $oldDataSiswa->ori_foto;
            }

            $oldDataSiswa->nis = $request->daftar_nis;
            $oldDataSiswa->nama = $request->daftar_nama;
            $oldDataSiswa->kelas = $request->daftar_kelas;
            $oldDataSiswa->alamat = $request->daftar_alamat;
            $oldDataSiswa->tempat_lahir = $request->daftar_tempat_lahir;
            $oldDataSiswa->jenis_kelamin = $request->daftar_jk;
            $oldDataSiswa->tanggal_lahir = $request->daftar_tgl_lahir;
            $oldDataSiswa->no_telp = $request->daftar_no_telp;
            $oldDataSiswa->ori_foto = $oriImageName;
            $oldDataSiswa->gen_foto = $imageName;
            $oldDataSiswa->save();

            $oldPendaftaran = $this->_get_pendaftaran_already_exist_by_id($request->id_pendaftaran);
            $oldPendaftaran->id_siswa = $oldDataSiswa->id;
            $oldPendaftaran->id_ekskul = $request->daftar_ekskul; 
            $oldPendaftaran->id_ekskul_opt = $request->daftar_ekskul_opt; 
            $oldPendaftaran->save();

            // $data_siswa = array(
            //     'nis' => $request->daftar_nis,
            //     'nama' => $request->daftar_nama,
            //     'kelas' => $request->daftar_kelas,
            //     'alamat' => $request->daftar_alamat,
            //     'tempat_lahir' => $request->daftar_tempat_lahir,
            //     'jenis_kelamin' => $request->daftar_jk,
            //     'tanggal_lahir' => $request->daftar_tgl_lahir,
            //     'no_telp' => $request->daftar_no_telp,
            //     'ori_foto' => $oriImageName,
            //     'gen_foto' => $imageName
            // );
            // DB::table('siswa')->where('id', '=', $request->id_siswa)->update($data_siswa);
            
            // $data_daftar_ekskul = array(
            //     'id_siswa' => $request->id_siswa,
            //     'id_ekskul' => $request->daftar_ekskul,
            //     'id_ekskul_opt' => $request->daftar_ekskul_opt
            // );

            // DB::table('pendaftaran_ekskul')->where('id', '=', $request->id_pendaftaran)->update($data_daftar_ekskul);

            $image_path = public_path('images/') . $oldDataSiswa->gen_foto;
            
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            DB::commit();

            if(!is_null($request->image)){
                $request->image->move(public_path('images'), $imageName);
            }

            $this->result->status = true;
            $this->result->message = 'Data berhasil disimpan.';
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->result->status = false;
            $this->result->message = 'Data gagal disimpan. ' . $th->getMessage();
        }

        return response()->json($this->result);

    }

    public function delete_daftar(Request $request){
        DB::beginTransaction();
        try {
            DB::table('pendaftaran_ekskul')->where('id', '=', $request->id_pendaftaran)->delete();
            $this->result->status = true;
            $this->result->message = 'Data berhasil dihapus.';
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->result->status = false;
            $this->result->message = 'Data gagal disimpan. ' . $th->getMessage();
        }

        return response()->json($this->result);
    }

    private function _get_siswa($id){
        $siswa = DB::table('siswa')->where('id', '=', $id)->first();
        return $siswa;
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

    public function get_ekskul(Request $request)
    {
        $ekskuls = DB::table('ekskul')->where('nama_ekskul', 'LIKE', '%' . $request->search . '%')->get();

        $datas = array();
        foreach ($ekskuls as $ekskul) {
            $datas[] = [
                'id' => $ekskul->id,
                'text' => $ekskul->nama_ekskul,
            ];
        }
        echo json_encode($datas);
    }

    public function get_pembina(Request $request)
    {
        $users = DB::table('users')
            ->where([
                ['nama', 'LIKE', '%' . $request->search . '%'],
                ['jabatan', '=', 'pembina']
            ])->get();

        $datas = array();
        foreach ($users as $user) {
            $datas[] = [
                'id' => $user->id,
                'text' => $user->nama,
            ];
        }
        echo json_encode($datas);
    }

    public function get_siswa(Request $request)
    {
        $users = DB::table('users')
            ->where([
                ['nama', 'LIKE', '%' . $request->search . '%'],
                ['jabatan', '=', 'siswa']
            ])->get();

        $datas = array();
        foreach ($users as $user) {
            $datas[] = [
                'id' => $user->id,
                'text' => $user->nama,
            ];
        }
        echo json_encode($datas);
    }
}
