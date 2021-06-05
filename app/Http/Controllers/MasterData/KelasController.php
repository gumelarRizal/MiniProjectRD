<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function data()
    {
        $kelass = DB::table('kelas')->get();
        return view('MasterData/Kelas/DataKelas', compact('kelass'));
    }

    public function add()
    {
        return view('MasterData/Kelas/AddKelas');
    }

    public function addProcess(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas',
        ], [
            'nama_kelas.required' => 'Nama Kelas Tidak Boleh Kosong !',
            'nama_kelas.unique' => 'Nama Kelas Sudah Ada !',
        ]);

        DB::table('kelas')->insert([
                'nama_kelas' => $request->nama_kelas
            ]);
        
        return redirect('kelas')->with('status', 'Data Berhasil diTambah !');
    }

    public function edit($id)
    {
        $kelasa = DB::table('kelas')->where('id', $id)->first();
        return view('MasterData/Kelas/EditKelas', compact('kelasa'));
    }

    public function editProcess(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas',
        ], [
            'nama_kelas.required' => 'Nama Kelas Tidak Boleh Kosong !',
            'nama_kelas.unique' => 'Nama Kelas Sudah Ada !',
        ]);

        DB::table('kelas')->where('id', $id)->update([
                'nama_kelas' => $request->nama_kelas
            ]);
        
        return redirect('kelas')->with('status', 'Data Berhasil diUbah !');
    }

    public function delete($id)
    {
        DB::table('kelas')->where('id', $id)->delete();
        return redirect('kelas')->with('status', 'Data Berhasil diHapus !');
    }
// Last Code
}
