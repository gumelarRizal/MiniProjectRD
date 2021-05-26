<?php

namespace App\Http\Controllers\Report;

use App\Exports\LaporanEkskulExport;
use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use stdClass;
use function App\Helpers\data_table;
use function App\Helpers\data_table_total;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

        $kelas = Siswa::distinct()->select('kelas')->groupBy('kelas')->get();

        return view(
            'Report.LaporanEkskul',
            ['pages' => $pages, 'kelas' => $kelas]
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

    public function exportToExcel(Request $request){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // $sheet->setCellValue('A1', 'SMP Negeri 34 Bandung');
        // $sheet->setCellValue('A2', 'LAPORAN NILAI MATA PELAJARAN SENI BUDAYA');

        $headerStyleArr = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ),
        );

        $dataLeftStyleArr = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ),
        );

        $sheet->setCellValue('A6', 'Kelas '.$request["kelas"].'');
        $sheet->mergeCells('A7:A8')->setCellValue('A7', 'No')->getStyle('A7:A8')->applyFromArray($headerStyleArr);
        $sheet->mergeCells('B7:C7')->setCellValue('B7', 'Nomor Induk Siswa')->getStyle('B7:C7')->applyFromArray($headerStyleArr);
        $sheet->mergeCells('D7:D8')->setCellValue('D7', 'Nama')->getStyle('D7:D8')->applyFromArray($headerStyleArr);
        $sheet->setCellValue('E7', 'L')->getStyle('E7')->applyFromArray($headerStyleArr);
        $sheet->setCellValue('E8', 'P')->getStyle('E8')->applyFromArray($headerStyleArr);
        $sheet->mergeCells('F7:F8')->setCellValue('F7', 'Ekskul')->getStyle('F7:F8')->applyFromArray($headerStyleArr);
        $sheet->mergeCells('G7:G8')->setCellValue('G7', 'Nilai')->getStyle('G7:G8')->applyFromArray($headerStyleArr);
        $sheet->mergeCells('H7:H8')->setCellValue('H7', 'Ekskul')->getStyle('H7:H8')->applyFromArray($headerStyleArr);
        $sheet->mergeCells('I7:I8')->setCellValue('I7', 'Nilai')->getStyle('I7:I8')->applyFromArray($headerStyleArr);
        $sheet->setCellValue('B8', 'Sekolah')->getStyle('B8')->applyFromArray($headerStyleArr);
        $sheet->setCellValue('C8', 'Nasional')->getStyle('C8')->applyFromArray($headerStyleArr);

        $select = array(
            'siswa.nama as nama_siswa',
            'siswa.id as id_siswa',
            'siswa.nis',
            'siswa.kelas',
            'siswa.alamat',
            'siswa.tempat_lahir',
            'siswa.jenis_kelamin',
            'pendaftaran_ekskul.id_ekskul',
            'pendaftaran_ekskul.id_ekskul_opt',
            'pendaftaran_ekskul.nilai as nilai_ekskul_wajib',
            'pendaftaran_ekskul.nilai_opt as nilai_ekskul_optional',
            'ekskul.nama_ekskul as nama_ekskul',
            'ekskul_2.nama_ekskul as nama_ekskul_opt',
        );
        $from = 'siswa';
        $where = array('siswa.kelas' => $request["kelas"]);
        $join = array(
            array('pendaftaran_ekskul', 'siswa.id', '=', 'pendaftaran_ekskul.id_siswa'),
            array('ekskul', 'pendaftaran_ekskul.id_ekskul', '=', 'ekskul.id'),
            array('ekskul as ekskul_2', 'pendaftaran_ekskul.id_ekskul_opt', '=', 'ekskul_2.id', 'left'),
        );

        $data = data_table($request, $select, $from ,$where , $join);

        $array = json_decode(json_encode($data), true);

        $rowDataStart = 9;
        $rowNum = 1;
        foreach($array as $key=>$value) {
            
            $sheet->setCellValue('A'.$rowDataStart, $rowNum++)->getStyle('A'.$rowDataStart)->applyFromArray($headerStyleArr);
            $sheet->setCellValue('B'.$rowDataStart, $value["nis"])->getStyle('B'.$rowDataStart)->applyFromArray($headerStyleArr);
            $sheet->setCellValue('C'.$rowDataStart, "")->getStyle('C'.$rowDataStart)->applyFromArray($headerStyleArr);
            $sheet->setCellValue('D'.$rowDataStart, $value["nama_siswa"])->getStyle('D'.$rowDataStart)->applyFromArray($dataLeftStyleArr);
            $sheet->setCellValue('E'.$rowDataStart, $value["jenis_kelamin"])->getStyle('E'.$rowDataStart)->applyFromArray($headerStyleArr);
            $sheet->setCellValue('F'.$rowDataStart, $value["nama_ekskul"])->getStyle('F'.$rowDataStart)->applyFromArray($dataLeftStyleArr);
            $sheet->setCellValue('G'.$rowDataStart, $value["nilai_ekskul_wajib"])->getStyle('G'.$rowDataStart)->applyFromArray($headerStyleArr);
            $sheet->setCellValue('H'.$rowDataStart, $value["nama_ekskul_opt"])->getStyle('H'.$rowDataStart)->applyFromArray($dataLeftStyleArr);
            $sheet->setCellValue('I'.$rowDataStart, $value["nilai_ekskul_optional"])->getStyle('I'.$rowDataStart)->applyFromArray($headerStyleArr);
            
            $rowDataStart++;
        }

        foreach (range('A','I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
            
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode('test.xlsx').'"');
        $writer->save('php://output');
    }
}
