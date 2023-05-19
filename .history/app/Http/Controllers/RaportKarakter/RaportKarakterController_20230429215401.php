<?php

namespace App\Http\Controllers\RaportKarakter;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Jurusan;
use App\Models\User;
use App\Models\Siswa;
use App\Models\AspekDPG;
use App\Models\Aspek4B;
use App\Models\PenilaianGuru;
use Illuminate\Http\Request;
use App\Models\UserDis;
use Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use App\Exports\RaporKarakter\Master;
use App\Models\DetailPG;
use Carbon\Carbon;
//Editor Kyta
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\TeacherHasTeaching;

class RaportKarakterController extends Controller
{
    //PROCEDURE
    public function index(Request $req)
    {
        //Get angkatan/kelas,jurusan
        $kelas = Angkatan::aktif()->get();
        $jurusan = Jurusan::get();



        return view('raportkarakter.index', ['kelas' => $kelas, 'jurusan' => $jurusan]);
    }

    public function downloadraportkarakter(Request $req)
    {
        if (Session::has('listpenilaian')) {
           //dd(Session::get('listpenilaian'));
            //dd(Session::get('listpenilaian'));
            $name = "cache-" . date('Y-m-d H-i-s') . ".xlsx";
            $filePath = 'exports/' . $name; // Specify the desired file path within the storage directory
            Excel::store(new Master(Session::get('listpenilaian')), $filePath, 'public_disk');
            //  return (new Master(Session::get('listpenilaian')))->download('Rapor Karakter.xlsx');


            //Editing Time
            $filePath2 = public_path($filePath);

            $spreadsheet = IOFactory::load($filePath2);

            $spreadsheet->setActiveSheetIndex(2);
            $sheet = $spreadsheet->getActiveSheet();

            $printarea = "";

            foreach(Session::get('listpenilaian')['siswa'] as $i => $sws){
                $printarea .= convertToExcelColumn(($i*7)+1)."1:".convertToExcelColumn(($i+1)*7)."66";
                if(isset(Session::get('listpenilaian')['siswa'][$i+1])){
                    $printarea.=",";
                }
            }
            //dd($printarea);

            $spreadsheet->getActiveSheet()->getPageSetup()->setPrintArea('A1:'.convertToExcelColumn(Session::get('listpenilaian')['siswa']->count()*7)."67");
            $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(Session::get('listpenilaian')['siswa']->count());
            $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(2);
            $spreadsheet->getActiveSheet()->getPageSetup()->setFitToPage(true);

            foreach(Session::get('listpenilaian')['siswa'] as $i => $s){
                $spreadsheet->getActiveSheet()->getColumnDimension(convertToExcelColumn(($i*7)+1))->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension(convertToExcelColumn(($i*7)+3))->setWidth(40);
                $spreadsheet->getActiveSheet()->getColumnDimension(convertToExcelColumn(($i*7)+4))->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension(convertToExcelColumn(($i*7)+5))->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension(convertToExcelColumn(($i*7)+6))->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension(convertToExcelColumn(($i*7)+7))->setWidth(15);
            }

            $spreadsheet->getActiveSheet()->getStyle('A1:'.convertToExcelColumn(Session::get('listpenilaian')['siswa']->count()*7)."67")
    ->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
            
            
            $writer = new Xlsx($spreadsheet);

            // Save the new .xlsx file
            $writer->save(storage_path($name));

            return response()->download(storage_path($name))->deleteFileAfterSend();
            
            echo "tes";
          // return response()->download(public_path($name));
        }
      //  return redirect()->back();
    }
    public function generateeraportkarakter(Request $req)
    {
        $params = [];
        $params["angkatan"] = $req->angkatan;
        $params["jurusan"] = $req->jurusan;
        $params["dari"] = $req->dari;
        $params["sampai"] = $req->sampai;


        if ($req->filled('semuaguru')) {
            $params["semua"] = true;
        } else {
            $params["semua"] = false;

            $params["listguru"] = $req->listguru;

            if ($params["listguru"] == null) {
                Alert::error("Gagal", "Dimohon untuk menginputkan list penilai");
                return redirect()->back();
            }
        }

        $rekaprk = $this->rekaperaportdetail($params);

     
        Session::put('listpenilaian', $rekaprk);

        return view('eraport.rekaperaportdetail', $rekaprk);

        dd($rekaprk);
    }

    //FUNCTION
    public function getpenilailist(Request $req)
    {
        $penilai = User::role(['Guru BK', 'Guru', 'Pamong Putra']);

        if ($req->filled('nama')) {
            $penilai = $penilai->where('name', 'LIKE', '%' . $req->nama . "%");
        }

        return json_encode($penilai->get());
    }

    public function rekaperaportdetail(array $params)
    {
        $angkatan = $params["angkatan"];
        $jurusan = $params['jurusan'];
        $dari = $params['dari'];
        $sampai = $params['sampai'];
        $semua = $params['semua'];


        $siswa = Siswa::where("id_angkatan", $angkatan)->where("id_jurusan", $jurusan)->orderBy("no_absen", "asc")->get();
        $aspek4b = Aspek4B::all();
        $kelas = Angkatan::find($angkatan)->kelas();
        $jurusan = Jurusan::find($jurusan);

        $gurubersangkutan = UserDis::get();
        if ($semua == false) {
            $gurubersangkutan =  UserDis::whereIn('id', $params['listguru'])->get();
        }


        //  dd($aspek4b);

        $rekaplist = [];

        foreach ($aspek4b as $j => $asp4b) {

            foreach ($siswa as $s => $sws) {
                $nis = $sws->nis;

                $listpenilaian = [];

                //Guru
                foreach ($gurubersangkutan as $gb) {
                    $query = AspekDPG::where("id_aspek", $asp4b->id_aspek)->whereHas("detailPG.siswa", function ($q) use ($sws) {
                        $q->where("nis_siswa", $sws->nis);
                    })->whereHas("detailPG.parent", function ($q) use ($dari, $sampai) {
                        $q->whereBetween("tanggal_penilaian", [$dari, $sampai]);
                    })->whereHas("detailPG.parent.penilai", function ($q) use ($gb) {
                        $q->where('id', $gb->id);
                    });

                    $data = $query->get()->count();
                    if ($data > 0) {
                        array_push($listpenilaian, [
                            "data" => $query,
                            "average" => $query->sum('nilai') / $query->get()->count()
                        ]);
                    }
                }

                $countpenilai = 0;
                $totalpenilaian = 0;

                foreach ($listpenilaian as $lp) {
                    $countpenilai += 1;
                    $totalpenilaian += $lp['average'];
                }

                $rata2penilaian = ($countpenilai < 1 or $totalpenilaian < 1) ? 0 : ($totalpenilaian / $countpenilai);


                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["point"] = $asp4b->point;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["subpoint"] = $asp4b->subpoint;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["aspek"] = $asp4b->keterangan;

                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["data"] = $sws;

                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_sekolah"]['count'] = $countpenilai;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_sekolah"]['jumlah'] = $totalpenilaian;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_sekolah"]['jumlah_akumulatif'] = $rata2penilaian;
            }
        }

        $semester = "Genap";

       // $jurusanril = Jurusan::find($jurusan);
        $angkatanril = Angkatan::find($angkatan);
        $walikelas = TeacherHasTeaching::where("id_jurusan",$jurusan->id_jurusan)-> where("id_angkatan",$angkatan)->whereHas("guru.roles.role", function($q) use($jurusan,$angkatan){
            $q->where("name","Wali Kelas");
        })->where("sebagai","LIKE","%".$angkatanril->kelas()."%")->where("sebagai","LIKE","%Wali Kelas%")->where("sampai",">",$dari)->first();


        $bulandari = Carbon::parse($dari)->month;
        $bulansampai = Carbon::parse($sampai)->month;

        if($bulandari <= 6 and $bulansampai <= 6){
            $semester = "Ganjil";
        }else if($bulandari > 6 and $bulansampai > 6){
            $semester = "Genap";
        }else{
            $semester = "Genap dan Ganjil";
        }

        //Rincian
        //Mendapatkan siswa dengan ni


        return ["siswa" => $siswa, "rekaplist" => $rekaplist, "kelas" => $kelas, "jurusan" => $jurusan->jurusan,"semester"=>$semester, "walikelas"=>$walikelas];
    }


    public function rincian(){
        $siswaN1 = DetailPG::with("siswa")->with(["siswa"=>function($q){
            $q->where("nilai",1);
        }])->whereHas("aspek_dpg", function($q){
            $q->where("nilai", 1);
        })->whereHas("parent", function($q){
            $q->whereMonth("tanggal_penilaian", date("m"));
        })->get();
        return view("outputeraport.rincian", ['rincian'=>$siswaN1]);
        dd($siswaN1);
    }
}
