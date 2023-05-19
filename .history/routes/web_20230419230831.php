<?php

use App\Events\BuatPesan;
use App\Http\Controllers\Admin\KonfigurasiPenggunaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAppController;
use App\Http\Controllers\Konseling\JadwalKonselingController;
use App\Http\Controllers\AsramaProject;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\DataSiswa\DataSiswaController;
use App\Http\Controllers\DataSiswa\RKGController;
use App\Http\Controllers\General\GeneralController;
use App\Http\Controllers\HakAkses\HakAksesSayaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KonfigurasiUmum\KonfigurasiController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\RaportKarakter\RaportKarakterController;
use App\Http\Controllers\ReservasiKonseling\ReservasiKonselingController;
use App\Http\Controllers\Siswa\SiswaController;
use App\Imports\Raport;
use Symfony\Component\HttpKernel\Profiler\Profile;

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


Route::controller(DashboardController::class)->middleware('auth')->group(function () {
    Route::get('/dashboard', "index")->name("dashboard");
});

Route::controller(RaportKarakterController::class)->middleware('auth')->group(function () {
    Route::get('/raportkarakter', 'index')->name('eraport.raportkarakter');
    Route::get('/generateraportkarakter', 'generateeraportkarakter')->name("eraport.generateraportkarakter");
    Route::get('/downloadraportkarakter', 'downloadraportkarakter')->name("eraport.downloadraportkarakter");
    Route::get('/getpenilailist', [RaportKarakterController::class, 'getpenilailist'])->name('eraport.getpenilailist');
});

Route::controller(ProfileController::class)->middleware("auth")->group(function(){
    Route::get('/profil', 'index')->name('profile.index');
    Route::post('/profile/injectpp', 'updatepp')->name("profile.injectpp");
});

Route::controller(HakAksesSayaController::class)->middleware("auth")->group( function(){
    Route::get('hakaksesaya', 'index')->name("hakaksessaya");
});


//Route::controller(Profile)


//DATASISWA CONTROLLER
Route::controller(DataSiswaController::class)->middleware("auth")->group(function () {
    Route::get('/datasiswa',  "index")->name('datasiswa');
    Route::get('/datajurusan/{angkatan}', "datajurusan")->name('datajurusan');
    Route::post('/datajurusan/tambahsiswa', "tambahsiswa")->name('datajurusan.tambahsiswa');
    Route::post('/datajurusan/tambahsiswaexcel', "tambahsiswaexcel")->name('datajurusan.tambahsiswa.excel');
    Route::get('/siswakelas/{angkatan}/{jurusan}', "siswakelas")->name('siswakelas');
    Route::get('/profilsiswa/{nis}', "profilsiswa")->name('profilsiswa');
    Route::get('/carisiswa',  "carisiswa")->name('carisiswa');
});

//Menu Asrama
Route::controller(AsramaProject::class)->middleware(["role:Pamong Putra"])->group(function () {
    Route::get('laporan_harian', 'tampil_laporan_harian')->name('laporan_harian');
    Route::get('detail_foto/{id}', 'detail_foto');
    Route::get('kembali/{id}', 'kembali_home');
    Route::get('postingan/{id_saja}', 'lihat_post')->name("asrama.laporanharian");
    Route::post('tambah_laporan', 'tambah_laporan')->name('tambah_laporan');
    Route::put('tambah_siswa', 'tambah_siswa');
});


//Route Menu Raport Karakter(Sisi Guru)
Route::controller(RKGController::class)->middleware(["role:Admin|Guru BK|Guru|Pamong Putra|Pamong Putri"])->group(function () {
    Route::get('/eraportkelas/{angkatan}/{jurusan}', "eraportkelas")->name("eraport.kelas");
    // Route::get('/eraport/rekaperaportdetail/{params}', [SuperAppController::class, "rekaperaportdetail"])->name("eraport.rekaperaportdetail");

    Route::get('/eraportkelas/tambahmanual/add/{params}', "tambaheraportmanual")->name("eraport.tambah.manual");
    Route::post('/eraportkelas/tambahmanual/store', "tambaheraportmanualstore")->name("eraport.tambahmanual.store");

    Route::post('/validasieraport', "validasieraport")->name("eraport.validasi");
    Route::get('/lihateraport/{id}', "lihateraport")->name("eraport.lihat");
    Route::put('/updateraport', "updateeraport")->name("eraport.update");

    Route::post('/senderaport', "senderaport")->name("eraport.send");
    Route::get('/hapuseraport/{id}', "hapusRKG" )->name("eraport.hapus");
});


Route::controller(KonfigurasiController::class)->middleware(["role:Admin"])->group(function () {
    Route::get('/konfigurasiumum', "index")->name("admin.konfigurasiumum");
    Route::get('/konfigurasiumum/jurusan', "konfigurasijurusan")->name("admin.konfigurasiumum.jurusan");
    Route::post('/konfigurasiumum/jurusan/tambah', "tambahjurusan")->name("admin.konfigurasiumum.jurusan.tambah");

    Route::get('/konfigurasiumum/angkatan',  "konfigurasiangkatan")->name("admin.konfigurasiumum.angkatan");
    Route::post('/konfigurasiumum/angkatan/tambah', "tambahangkatan")->name("admin.konfigurasiumum.angkatan.tambah");

    Route::get('konfigurasi/kategori',  "konfigurasikategori")->name('admin.konfigurasiumum.kategori');
    Route::post('/konfigurasiumum/kategori/tambah',  "tambahkategori")->name('admin.konfigurasiumum.kategori.tambah');

    Route::get('hakakseskelas/{id}',  "hakakseskelas")->name("admin.konfigurasiumum.pengguna.hak");
    Route::post('hakakseskelas/tambah', "tambahhakakseskelas")->name("admin.konfigurasiumum.pengguna.hak.tambah");
});

Route::resource("konfigurasipengguna", KonfigurasiPenggunaController::class, [
    'names'=>[
        "index"=>'admin.konfigurasiumum.pengguna'
    ]
    ]);

Route::controller(ReservasiKonselingController::class)->middleware(["role:Admin|Guru BK|Konselor"])->group(function () {
    Route::get('/reservasikonseling', "index")->name("bk.reservasikonseling");
    Route::put('/tolakreservasi', "tolakreservasi")->name("bk.tolakreservasi");
    Route::put('/tanggapireservasi',  "tanggapireservasi")->name("bk.tanggapireservasi");
    Route::put('/ubahjadwalreservasi', "ubahreservasi")->name("bk.ubahjadwalreservasi");
    Route::get("/bk/jadwalsaya", "jadwalsaya")->name("bk.jadwalsaya");

    Route::post("/bk/hapusjadwal", "hapus")->name("bk.hapusjadwal");
});

Route::controller(JadwalKonselingController::class)->group(function () {
    Route::post("/profil/storejadwal",  "storejadwal")->name("profil.storejadwal");
    Route::get("/profil/lihatjadwal/{id}", "lihatjadwal")->name("profil.lihatjadwal");
    Route::get("/bk/lihatdetailjadwal", "lihatdetailjadwal")->name('bk.getdetailjadwal');
    Route::put("/bk/editdetailjadwal", "editdetailjadwal")->name('bk.editdetailjadwal');
    Route::put("/bk/selesaireservasi", "selesaireservasi")->name('bk.selesaireservasi');
    Route::put("/bk/updatejadwal", "updatejadwal")->name('bk.updatejadwal');
    Route::get("/bk/getinfosesi", "getinfosesi")->name('bk.getinfosesi');
    Route::post("/profil/storejadwal",  "storejadwal")->name("profil.storejadwal");

    Route::get("/profil/lihatjadwal/{id}", "lihatjadwal")->name("profil.lihatjadwal");
});


Route::controller(HomeController::class)->middleware(["role:Pamong Putra|Pamong Putri|Admin|Guru BK|Kepala Sekolah|Kesiswaan"])->group(function () {
    Route::get('/beranda', "beranda")->name("beranda");
    Route::post('/tambahcatatan', "tambahcatatan")->name("tambahcatatan");
    Route::get('/listsiswa', "listsiswa")->name("listsiswa");
});


Route::controller(SiswaController::class)->middleware("auth:siswa")->group(function () {
    Route::get('/pengajuankonseling', "pengajuankonseling")->name("siswa.pengajuankonseling");
    Route::get('/pengajuankonseling/carikonselor', "carikonselor")->name("siswa.carikonselor");
    Route::post('/pengajuankonseling/store', "pengajuankonselingstore")->name("siswa.pengajuankonseling.store");


    Route::get('/riwayatkonseling', "riwayatkonseling")->name("siswa.riwayatkonseling");
    Route::get('/ajukansesi/{id}',  "ajukansesi")->name("siswa.ajukansesi");
    Route::get('/batalkankonseling', "batalkonseling")->name("siswa.batalkonseling");
});

Auth::routes();


Route::group([],function () {
    Route::get('/siswa/register', [SuperAppController::class, "registersiswa"])->name("siswa.register");
    Route::post('/siswa/register', [SuperAppController::class, "registersiswastore"])->name("siswa.register.store");

    Route::get('/siswa/login', [SuperAppController::class, "loginsiswa"])->name("siswa.login");
    Route::post('/siswa/login', [SuperAppController::class, "loginsiswaattempt"])->name("siswa.login.attempt");

    Route::get('getnotif', [GeneralController::class, 'getnotif'])->name('general.getnotif');
});

Route::group(["middleware"=>["role:Admin|Guru BK"]],function () {
    Route::post('/injectraport/store', [SuperAppController::class, "injectsiswastore"])->name('injectsiswa.store');
  
   
});


//Route update transition      
require __DIR__ . '/auth.php';
