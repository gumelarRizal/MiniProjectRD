<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index(){
        $pages = "Menu Siswa";
        $siswa = DB::table('siswa')->get();
        return view('MasterData.Siswa.Siswa',['siswa'=>$siswa,'pages'=>$pages]);
    }
    public function delete($id){
        DB::table('siswa')->where('ID',$id)->delete();
        return redirect()->back();
    }
}
