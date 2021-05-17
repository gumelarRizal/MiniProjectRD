<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use stdClass;

use function App\Helpers\data_table;
use function App\Helpers\data_table_total;
use Illuminate\Support\Facades\DB;

class InputNilaiController extends Controller
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
        $pages = "Menu Input Nilai";
        
        // $ekskuls = DB::table('ekskul')
        //     ->select('ekskul.id','ekskul.nama_ekskul', 'jadwal_ekskul.hari', 'jadwal_ekskul.tempat', 'pelatih.nama as nama_pelatih')
        //     ->join('jadwal_ekskul', 'ekskul.id', '=', 'jadwal_ekskul.id_ekskul')
        //     ->join('pelatih', 'jadwal_ekskul.id_pelatih', '=', 'pelatih.id')
        //     ->get();

        return view(
            'Transaction.InputNilai',
            ['pages' => $pages]
        );
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
