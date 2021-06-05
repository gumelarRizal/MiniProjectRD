<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EkskulController extends Controller
{
    public function data()
    {
        // $ekskuls = DB::table('ekskul')->get();
        $ekskuls = DB::table('ekskul')
            ->select('ekskul.id','ekskul.nama_ekskul','ekskul.kategori','pembina.nama','ekskul.id_pembina')
            ->leftJoin('pembina', 'ekskul.id_pembina', '=', 'pembina.id')
            ->get();
        return view('MasterData/Ekskul/DataEkskul', compact('ekskuls'));
    }

    public function add()
    {
        $pembinas = DB::table('pembina')->get();
        return view('MasterData/Ekskul/AddEkskul', compact('pembinas'));
    }

    public function addProcess(Request $request)
    {
        $request->validate([
            'nama_ekskul' => 'required|unique:ekskul,nama_ekskul',
        ], [
            'nama_ekskul.required' => 'Nama Ekskul Tidak Boleh Kosong !',
            'nama_ekskul.unique' => 'Nama Ekskul Sudah Ada !',
        ]);

        if($request->kategori == 'Wajib'){ 
            $categorys = 1;
        }else{
            $categorys = 0;
        }

        DB::table('ekskul')->insert([
                'nama_ekskul' => $request->nama_ekskul,
                'kategori' => $request->kategori,
                'id_pembina' => $request->id_pembina,
                'category' => $categorys
            ]);
        
        return redirect('ekskul')->with('status', 'Data Berhasil diTambah !');
    }

    public function edit($id)
    {
        $pembinas = DB::table('pembina')->get();
        $ekskull = DB::table('ekskul')->where('id', $id)->first();
        return view('MasterData/Ekskul/EditEkskul', compact('ekskull','pembinas'));
    }

    public function editProcess(Request $request, $id)
    {
        $request->validate([
            'nama_ekskul' => ['required', Rule::unique('ekskul','nama_ekskul')->ignore($id)],
        ], [
            'nama_ekskul.required' => 'Nama Ekskul Tidak Boleh Kosong !',
            'nama_ekskul.unique' => 'Nama Ekskul Sudah Ada !',
        ]);

        if($request->kategori == 'Wajib'){ 
            $categorys = 1;
        }else{
            $categorys = 0;
        }

        DB::table('ekskul')->where('id', $id)->update([
                'nama_ekskul' => $request->nama_ekskul,
                'kategori' => $request->kategori,
                'id_pembina' => $request->id_pembina,
                'category' => $categorys
            ]);
        
        return redirect('ekskul')->with('status', 'Data Berhasil diUbah !');
    }

    public function delete($id)
    {
        DB::table('ekskul')->where('id', $id)->delete();
        return redirect('ekskul')->with('status', 'Data Berhasil diHapus !');
    }
// Last Code
}
