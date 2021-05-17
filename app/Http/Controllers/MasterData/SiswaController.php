<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index(){
        $pages = "Menu Siswa";
        $siswa = DB::table('siswa')->get();
        $ekskuls = DB::table('ekskul')
            ->select('ekskul.id','ekskul.nama_ekskul', 'jadwal_ekskul.hari', 'jadwal_ekskul.tempat', 'pelatih.nama as nama_pelatih')
            ->join('jadwal_ekskul', 'ekskul.id', '=', 'jadwal_ekskul.id_ekskul')
            ->join('pelatih', 'jadwal_ekskul.id_pelatih', '=', 'pelatih.id')
            ->get();
        return view('MasterData.Siswa.Siswa',['siswa'=>$siswa,'pages'=>$pages,'ekskul'=>$ekskuls]);
    }
    public function create(Request $request){

        DB::beginTransaction();
        try
        {
            if(!is_null($request->image)){
                $imageName = time().'.'.$request->image->getClientOriginalName(); 
                $request->image->move(public_path('images'), $imageName);
            }
            $siswa = Siswa::Create(
                [
                    'id' => $request->id,
                    'nis' => $request->nis,
                    'nama' => $request->nama,
                    'kelas' => $request->kelas,
                    'alamat' => $request->alamat,
                    'tempat_lahir' => $request->tempat_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'no_telp' => $request->no_telp,
                    'foto' => $imageName,
                ]);
            DB::commit();
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data berhasil di tambahkan'
                ]
            );
        }
        catch(\Throwable $th)
        {
            DB::rollback();
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data gagal di tambahkan . '.$th->getMessage()
                ]
            );
        }
        
    }
    public function delete($id){
        DB::table('siswa')->where('ID',$id)->delete();
        return redirect()->back();
    }
}
