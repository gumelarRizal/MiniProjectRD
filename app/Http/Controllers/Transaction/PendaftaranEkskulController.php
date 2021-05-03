<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\pendaftaran_ekskul;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class PendaftaranEkskulController extends Controller
{
    private $data;
    private $result;

    private function _set_result() {
        $this->result = new stdClass();
        $this->result->status = false;
        $this->result->message = '';
        $this->result->data = new stdClass();
    }

    public function __construct() {
        // echo 'masuk default';
        $this->_set_result();
    }

    public function index(){
        $pages = "Menu Pendaftaran Ekskul";
        $pendaftaran_ekskuls = DB::table('pendaftaran_ekskul')
            ->select('pendaftaran_ekskul.id as id_pendaftaran', 'siswa.nama as nama_siswa', 
                'ekskul.nama_ekskul as nama_ekskul', 'pembina.nama as nama_pembina', 'pendaftaran_ekskul.nilai as nilai')
            ->join('ekskul', 'pendaftaran_ekskul.id_ekskul', '=', 'ekskul.id')
            ->join('siswa', 'pendaftaran_ekskul.id_siswa', '=', 'siswa.id')
            ->join('pembina', 'ekskul.id_pembina', '=', 'pembina.id', 'left')
            ->get();
        return view('Transaction.PendaftaranEkskul',['pendaftaran_ekskuls'=>$pendaftaran_ekskuls,'pages'=>$pages]);
    }

    public function daftar(Request $request){
        DB::beginTransaction();
        try {
            $siswa = new Siswa();
            $siswa->nis = $request->daftar_nis;
            $siswa->nama = $request->daftar_nama;
            $siswa->kelas = $request->daftar_kelas;
            $siswa->alamat = $request->daftar_alamat;
            $siswa->tempat_lahir = $request->daftar_tempat_lahir;
            $siswa->jenis_kelamin = $request->daftar_jk;
            $siswa->tanggal_lahir = $request->daftar_tgl_lahir;
            $siswa->no_telp = $request->daftar_no_telp;
            $siswa->foto = $request->image;
            $siswa->save();

            $daftar_ekskul = new pendaftaran_ekskul();
            $daftar_ekskul->id_siswa = $siswa->id;
            $daftar_ekskul->id_ekskul = 1; //todo
            $daftar_ekskul->save();

            DB::commit();
            $this->result->status = true;
            $this->result->message = 'Data berhasil disimpan.';
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->result->status = false;
            $this->result->message = 'Data gagal disimpan. ' . $th->getMessage();
        }
        
        // $pendaftaran_ekskul = new pendaftaran_ekskul();
        // $pendaftaran_ekskul->id_siswa = $request->daftar_siswa;
        // $pendaftaran_ekskul->id_ekskul = $request->daftar_ekskul;
        // $pendaftaran_ekskul->id_pembina = $request->daftar_pembina;
        // $pendaftaran_ekskul->save();

        // echo json_encode($this->result);
        return response()->json($this->result);
        // return redirect()->route('daftar_ekskul')->with('alert-success','Data berhasil dihapus!');
    }

    public function get_ekskul(Request $request) {
        $ekskuls = DB::table('ekskul')->where('nama_ekskul', 'LIKE', '%'.$request->search.'%')->get();

        $datas = array();
        foreach ($ekskuls as $ekskul) {
            $datas[] = [
                'id' => $ekskul->id,
                'text' => $ekskul->nama_ekskul,
            ];
        }
        echo json_encode($datas);
    }

    public function get_pembina(Request $request) {
        $users = DB::table('users')
            ->where([
                ['nama', 'LIKE', '%'.$request->search.'%'],
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

    public function get_siswa(Request $request) {
        $users = DB::table('users')
            ->where([
                ['nama', 'LIKE', '%'.$request->search.'%'],
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
