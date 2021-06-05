<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembinaController extends Controller
{
    public function data()
    {
        $pembinas = DB::table('pembina')->get();
        return view('MasterData/Pembina/DataPembina', compact('pembinas'));
    }

    public function add()
    {
        return view('MasterData/Pembina/AddPembina');
    }

    public function addProcess(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:pembina,nip',
            'nama' => 'required',
            'jabatan' => 'required',
        ], [
            'nip.required' => 'NIP Pembina Tidak Boleh Kosong !',
            'nip.unique' => 'NIP Pembina Sudah Ada !',
            'nama.required' => 'Nama Pembina Tidak Boleh Kosong !',
            'jabatan.required' => 'Jabatan Pembina Tidak Boleh Kosong !',
        ]);

        DB::table('pembina')->insert([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'jabatan' => $request->jabatan
            ]);
        
        return redirect('pembina')->with('status', 'Data Berhasil diTambah !');
    }

    public function edit($nip)
    {
        $pembinaa = DB::table('pembina')->where('nip', $nip)->first();
        return view('MasterData/Pembina/EditPembina', compact('pembinaa'));
    }

    public function editProcess(Request $request, $nip)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
        ], [
            'nama.required' => 'Nama Pembina Tidak Boleh Kosong !',
            'jabatan.required' => 'Jabatan Pembina Tidak Boleh Kosong !',
        ]);

        DB::table('pembina')->where('nip', $nip)->update([
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'jabatan' => $request->jabatan
            ]);
        
        return redirect('pembina')->with('status', 'Data Berhasil diUbah !');
    }

    public function delete($nip)
    {
        DB::table('pembina')->where('nip', $nip)->delete();
        return redirect('pembina')->with('status', 'Data Berhasil diHapus !');
    }

// Last Code
}
