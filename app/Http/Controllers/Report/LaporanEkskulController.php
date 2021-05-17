<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use stdClass;
use function App\Helpers\data_table;
use function App\Helpers\data_table_total;
use Illuminate\Support\Facades\DB;

class LaporanEkskulController extends Controller
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
        $pages = "Menu Laporan Ekskul";
        return view(
            'Report.LaporanEkskul',
            ['pages' => $pages]
        );
    }

    public function read(Request $request){
        $select = array(
            'ekskul.nama_ekskul',
            DB::raw('count(1) as jumlah_pendaftar'),
        );
        $from = 'pendaftaran_ekskul';
        $where = null;
        $join = array(
            array('ekskul', 'pendaftaran_ekskul.id_ekskul', '=', 'ekskul.id')
        );
        $group_by = "pendaftaran_ekskul.id_ekskul";
        
        $this->result->status = true;
        $this->result->draw = $request->draw;
        $this->result->data = data_table($request, $select, $from ,$where , $join, $group_by);
        $this->result->recordsTotal = data_table_total($request, $select, $from,false,$where , $join, $group_by)->count();
        $this->result->recordsFiltered = data_table_total($request, $select, $from,true,$where , $join, $group_by)->count();

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
        //
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
}
