<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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

    //DANIAR ADD [START]
    public function data()
    {
        $siswas = DB::table('siswa')->get();
        return view('MasterData/Siswa/DataSiswa', compact('siswas'));
    }

    public function add()
    {
        $kelass = DB::table('kelas')->get();
        return view('MasterData/Siswa/AddSiswa', compact('kelass'));
    }

    public function addProcess(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama' => 'required',
            'no_telp' => 'required',
            'tempat_lahir' => 'required',
        ], [
            'nis.required' => 'NIS Siswa Tidak Boleh Kosong !',
            'nis.unique' => 'NIS Siswa Sudah Ada !',
            'nama.required' => 'Nama Siswa Tidak Boleh Kosong !',
            'no_telp.required' => 'No HP Tidak Boleh Kosong !',
            'tempat_lahir.required' => 'Tempat Lahir Tidak Boleh Kosong !',
        ]);

        if(!is_null($request->image)){
            $imageName = time().'_'.$request->image->getClientOriginalName(); 
            $request->image->move(public_path('images'), $imageName);
        }

        DB::table('siswa')->insert([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'alamat' => $request->alamat,
                'tempat_lahir' => $request->tempat_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_telp' => $request->no_telp,
                'ori_foto' => $imageName
            ]);
        
        return redirect('siswa')->with('status', 'Data Berhasil diTambah !');
    }

    public function edit($id)
    {
        $siswaa = DB::table('siswa')->where('id', $id)->first();
        $kelass = DB::table('kelas')->get();
        return view('MasterData/Siswa/EditSiswa', compact('kelass','siswaa'));
    }

    public function editProcess(Request $request, $id)
    {
        $request->validate([
            'nis' => ['required', Rule::unique('siswa','nis')->ignore($id)],
            'nama' => 'required',
            'no_telp' => 'required',
            'tempat_lahir' => 'required',
        ], [
            'nis.required' => 'NIS Siswa Tidak Boleh Kosong !',
            'nis.unique' => 'NIS Siswa Sudah Ada !',
            'nama.required' => 'Nama Siswa Tidak Boleh Kosong !',
            'no_telp.required' => 'No HP Tidak Boleh Kosong !',
            'tempat_lahir.required' => 'Tempat Lahir Tidak Boleh Kosong !',
        ]);

        if(!is_null($request->image)){
            $imageName = time().'_'.$request->image->getClientOriginalName(); 
            $request->image->move(public_path('images'), $imageName);
        }

        if($request->has('image')){
            DB::table('siswa')->where('id', $id)->update([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'alamat' => $request->alamat,
                'tempat_lahir' => $request->tempat_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_telp' => $request->no_telp,
                'ori_foto' => $imageName
            ]);
        }else{
            DB::table('siswa')->where('id', $id)->update([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'alamat' => $request->alamat,
                'tempat_lahir' => $request->tempat_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_telp' => $request->no_telp
            ]);
        }

        return redirect('siswa')->with('status', 'Data Berhasil diUbah !');
    }

    public function delete_siswa($id)
    {
        DB::table('siswa')->where('id', $id)->delete();
        return redirect('siswa')->with('status', 'Data Berhasil diHapus !');
    }
    //DANIAR ADD [END]
//Last Code
}
