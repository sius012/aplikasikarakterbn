<?php

use App\Events\BuatPesan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAppController;
use App\Http\Controllers\Konseling\JadwalKonselingController;
use App\Http\Controllers\AsramaProject;
use App\Http\Controllers\General\GeneralController;
use App\Http\Controllers\RaportKarakter\RaportKarakterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    BuatPesan::dispatch("Halo kamu berhasil");
    return view('welcome');
})->name("welcome");

Route::group(["middleware" => "auth"], function () {
    Route::view('laporan_harian', 'laporan_asrama.laporan_harian');
    Route::view('ceknilaikelas', 'workbench.ceknilaikelas');


    Route::get('/getpenilailist', [RaportKarakterController::class, 'getpenilailist'])
    
    Route::get('getnotif',[GeneralController::class,'getnotif'])->name('general.getnotif');

    Route::get('laporan_harian',[AsramaProject::class,'tampil_laporan_harian'])->name('laporan_harian');

    Route::get('detail_foto/{id}',[AsramaProject::class,'detail_foto']);

    Route::get('kembali/{id}',[AsramaProject::class,'kembali_home']);
    
    Route::get('postingan/{id_saja}',[AsramaProject::class,'lihat_post'])->name("asrama.laporanharian");

    Route::post('tambah_laporan', [AsramaProject::class, 'tambah_laporan'])->name('tambah_laporan');

    Route::put('tambah_siswa',[AsramaProject::class,'tambah_siswa']);
    
    Route::view('postingan', 'laporan_asrama.postingan');


    Route::view('test_saja', 'testing.mytest');


    Route::get('/dashboard', [SuperAppController::class, "dashboard"])->name("dashboard");

    Route::get('/datasiswa', [SuperAppController::class, "datasiswa"])->name('datasiswa');

    Route::get('/datajurusan/{angkatan}', [SuperAppController::class, "datajurusan"])->name('datajurusan');
    Route::post('/datajurusan/tambahsiswa', [SuperAppController::class, "tambahsiswa"])->name('datajurusan.tambahsiswa');
    Route::post('/datajurusan/tambahsiswaexcel', [SuperAppController::class, "tambahsiswaexcel"])->name('datajurusan.tambahsiswa.excel');

    Route::get('/siswakelas/{angkatan}/{jurusan}', [SuperAppController::class, "siswakelas"])->name('siswakelas');

    Route::get('/profilsiswa/{nis}', [SuperAppController::class, "profilsiswa"])->name('profilsiswa');
    Route::get('/eraportkelas/{angkatan}/{jurusan}', [SuperAppController::class, "eraportkelas"])->name("eraport.kelas");
    Route::get('/eraport/rekaperaportdetail/{params}', [SuperAppController::class, "rekaperaportdetail"])->name("eraport.rekaperaportdetail");

    Route::get('/eraportkelas/tambahmanual/add/{params}', [SuperAppController::class, "tambaheraportmanual"])->name("eraport.tambah.manual");
    Route::post('/eraportkelas/tambahmanual/store', [SuperAppController::class, "tambaheraportmanualstore"])->name("eraport.tambahmanual.store");

    Route::post('/validasieraport', [SuperAppController::class, "validasieraport"])->name("eraport.validasi");
    Route::get('/lihateraport/{id}', [SuperAppController::class, "lihateraport"])->name("eraport.lihat");
    Route::put('/updateraport', [SuperAppController::class, "updateeraport"])->name("eraport.update");
    Route::get('/rekapraport/{angkatan}/{jurusan}', [SuperAppController::class, "rekaperaport"])->name("eraport.rekap");

    Route::post('/senderaport', [SuperAppController::class, "senderaport"])->name("eraport.send");

    Route::post('/tambahcatatan', [SuperAppController::class, "tambahcatatan"])->name("tambahcatatan");

    //
    Route::get('/eraport', [SuperAppController::class, "eraport"])->name("eraport");

    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/konfigurasiumum', [SuperAppController::class, "konfigurasiumum"])->name("admin.konfigurasiumum");

    Route::get('/datasiswa', [SuperAppController::class, "datasiswa"])->name('datasiswa');

    Route::get('/carisiswa', [SuperAppController::class, "carisiswa"])->name('carisiswa');

    Route::get('/konfigurasiumum/jurusan', [SuperAppController::class, "konfigurasijurusan"])->name("admin.konfigurasiumum.jurusan");
    Route::post('/konfigurasiumum/jurusan/tambah', [SuperAppController::class, "tambahjurusan"])->name("admin.konfigurasiumum.jurusan.tambah");

    Route::get('/konfigurasiumum/angkatan', [SuperAppController::class, "konfigurasiangkatan"])->name("admin.konfigurasiumum.angkatan");
    Route::post('/konfigurasiumum/angkatan/tambah', [SuperAppController::class, "tambahangkatan"])->name("admin.konfigurasiumum.angkatan.tambah");

    Route::get('/konfigurasiumum/pengguna', [SuperAppController::class, "konfigurasipengguna"])->name("admin.konfigurasiumum.pengguna");
    Route::post('/konfigurasiumum/kategori/tambah', [SuperAppController::class, "tambahkategori"])->name('admin.konfigurasiumum.kategori.tambah');

    Route::get('kategori', [SuperAppController::class, "konfigurasikategori"])->name('admin.konfigurasiumum.kategori');

    Route::view("/testing", "testing.customtooltips");

    Route::get('hakakseskelas/{id}', [SuperAppController::class, "hakakseskelas"])->name("admin.konfigurasiumum.pengguna.hak");
    Route::post('hakakseskelas/tambah', [SuperAppController::class, "tambahhakakseskelas"])->name("admin.konfigurasiumum.pengguna.hak.tambah");

    //Route Home
    Route::get('/beranda', [SuperAppController::class, "beranda"])->name("beranda");
    Route::get('/listsiswa', [SuperAppController::class, "listsiswa"])->name("listsiswa");

    //Konseling
    Route::get('/reservasikonseling', [SuperAppController::class, "reservasikonseling"])->name("bk.reservasikonseling");
    Route::put('/tolakreservasi', [SuperAppController::class, "tolakreservasi"])->name("bk.tolakreservasi");
    Route::put('/tanggapireservasi', [SuperAppController::class, "tanggapireservasi"])->name("bk.tanggapireservasi");
    Route::put('/ubahjadwalreservasi', [SuperAppController::class, "ubahreservasi"])->name("bk.ubahjadwalreservasi");


    Route::get("/bk/jadwalsaya", [SuperAppController::class,"profil"])->name("bk.jadwalsaya");
    Route::post("/bk/hapusjadwal", [JadwalKonselingController::class,"hapus"])->name("bk.hapusjadwal");
    Route::post("/profil/storejadwal", [SuperAppController::class,"storejadwal"])->name("profil.storejadwal");
    Route::get("/profil/lihatjadwal/{id}", [SuperAppController::class,"lihatjadwal"])->name("profil.lihatjadwal");
    Route::get("/bk/lihatdetailjadwal", [SuperAppController::class,"lihatdetailjadwal"])->name('bk.getdetailjadwal');
    Route::put("/bk/editdetailjadwal", [SuperAppController::class,"editdetailjadwal"])->name('bk.editdetailjadwal');
    Route::put("/bk/selesaireservasi", [SuperAppController::class,"selesaireservasi"])->name('bk.selesaireservasi');
    Route::put("/bk/updatejadwal", [SuperAppController::class,"updatejadwal"])->name('bk.updatejadwal');
    Route::get("/bk/getinfosesi", [SuperAppController::class,"getinfosesi"])->name('bk.getinfosesi');
    Route::get("/profil", [SuperAppController::class, "profil"])->name("profil");
    Route::post("/profil/storejadwal", [SuperAppController::class, "storejadwal"])->name("profil.storejadwal");
    
    Route::get("/profil/lihatjadwal/{id}", [SuperAppController::class, "lihatjadwal"])->name("profil.lihatjadwal");
});

Route::get('/injectsiswa', [SuperAppController::class, "injectsiswa"]);

//Siswa 
Route::middleware("auth:siswa")->group(function () {
    Route::get('/pengajuankonseling', [SuperAppController::class, "pengajuankonseling"])->name("siswa.pengajuankonseling");
    Route::get('/pengajuankonseling/carikonselor', [SuperAppController::class, "carikonselor"])->name("siswa.carikonselor");
    Route::post('/pengajuankonseling/store', [SuperAppController::class, "pengajuankonselingstore"])->name("siswa.pengajuankonseling.store");


    Route::get('/riwayatkonseling', [SuperAppController::class, "riwayatkonseling"])->name("siswa.riwayatkonseling");
    Route::get('/ajukansesi/{id}',[SuperAppController::class, "ajukansesi"])->name("siswa.ajukansesi");
    Route::get('/batalkankonseling',[SuperAppController::class, "batalkonseling"])->name("siswa.batalkonseling");
});
Route::get('/siswa/register', [SuperAppController::class, "registersiswa"])->name("siswa.register");
Route::post('/siswa/register', [SuperAppController::class, "registersiswastore"])->name("siswa.register.store");

Route::get('/siswa/login', [SuperAppController::class, "loginsiswa"])->name("siswa.login");
Route::post('/siswa/login', [SuperAppController::class, "loginsiswaattempt"])->name("siswa.login.attempt");

Route::post('/injectraport/store', [SuperAppController::class, "injectsiswastore"])->name('injectsiswa.store');
Route::get('/injectphotoprofile', [SuperAppController::class, "injectphotoprofile"]);

Route::view("/tester","workbench.test");
require __DIR__ . '/auth.php';