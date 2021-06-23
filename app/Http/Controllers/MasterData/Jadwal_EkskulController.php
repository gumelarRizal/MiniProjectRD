<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Jadwal_EkskulController extends Controller
{
    public function data()
    {
        $jadwal_eksuls = DB::table('jadwal_ekskul')
            ->select('ekskul.nama_ekskul', 'jadwal_ekskul.hari', 'jadwal_ekskul.tempat', 'pelatih.nama', 'jadwal_ekskul.id')
            ->leftJoin('ekskul', 'jadwal_ekskul.id_ekskul', '=', 'ekskul.id')
            ->leftJoin('pelatih', 'jadwal_ekskul.id_pelatih', '=', 'pelatih.id')
            ->orderBy('id', 'desc')
            ->get();
        return view('MasterData/Jadwal_Ekskul/DataJadwal_Ekskul', compact('jadwal_eksuls'));
    }

    public function add()
    {
        $pelatihs = DB::table('pelatih')->get();
        $ekskuls = DB::table('ekskul')->get();
        return view('MasterData/Jadwal_Ekskul/AddJadwal_Ekskul', compact('pelatihs','ekskuls'));
    }

    public function addProcess(Request $request)
    {
        $count_items = count($request->id_ekskul);
        for($i = 0; $i < $count_items; $i++) 
        {
            //Insert Ke jadwal_ekskul
            DB::table('jadwal_ekskul')->insert([
                'id_ekskul' => $request->id_ekskul[$i],
                'hari' => $request->hari[$i],
                'tempat' => $request->tempat[$i],
                'id_pelatih' => $request->id_pelatih
            ]);
        }
        return redirect('jadwal_ekskul')->with('status', 'Data Berhasil diTambah !');
    }

    public function edit($id)
    {
        // $pelatihs = DB::table('pelatih')->get();
        $ekskuls = DB::table('ekskul')->get();
        $jadwal_eksulss = DB::table('jadwal_ekskul')
            ->select('ekskul.nama_ekskul', 'jadwal_ekskul.hari', 'jadwal_ekskul.tempat', 'pelatih.nama', 'jadwal_ekskul.id', 'jadwal_ekskul.id_ekskul')
            ->leftJoin('ekskul', 'jadwal_ekskul.id_ekskul', '=', 'ekskul.id')
            ->leftJoin('pelatih', 'jadwal_ekskul.id_pelatih', '=', 'pelatih.id')
            ->where('jadwal_ekskul.id', $id)
            ->first();
        return view('MasterData/Jadwal_Ekskul/EditJadwal_Ekskul', compact('jadwal_eksulss','ekskuls'));
    }

    public function editProcess(Request $request, $id)
    {
        $request->validate([
            'tempat' => 'required',
        ], [
            'tempat.required' => 'Tempat Tidak Boleh Kosong !',
        ]);

        DB::table('jadwal_ekskul')->where('id', $id)->update([
                'id_ekskul' => $request->id_ekskul,
                'hari' => $request->hari,
                'tempat' => $request->tempat
            ]);
        return redirect('jadwal_ekskul')->with('status', 'Data Berhasil diUbah !');
    }

    public function delete($id)
    {
        DB::table('jadwal_ekskul')->where('id', $id)->delete();
        return redirect('jadwal_ekskul')->with('status', 'Data Berhasil diHapus !');
    }
    // Last Code
}
