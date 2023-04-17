<?php

namespace App\Http\Controllers;

use App\Events\BuatPesan;
use App\Events\BuatReservasi;
use App\Http\Requests\Auth\LoginRequestSiswa;
use App\Models\Angkatan;
use App\Models\Aspek4B;
use App\Models\CatatanSikap;
use App\Models\Jurusan;
use App\Models\Kategori;
use App\Models\Lampiran;
use App\Models\PenilaianGuru;
use App\Models\Project;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\AspekDPG;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Raport;
use App\Models\DetailPG;
use App\Models\User;
use App\Imports\SiswaImport;
use App\Models\AlamatSiswa;
use App\Models\BillingKonseling;
use App\Models\DetailJK;
use App\Models\DetailSiswa;
use App\Models\ModelHasRoles;
use App\Models\PengajuanKonseling;
use Spatie\Permission\Models\Role;
use App\Models\TeacherHasTeaching;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Models\JadwalKonseling;
use App\Models\Notification;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;


use function PHPSTORM_META\map;

class SuperAppController extends Controller
{

    public function dashboardFunc(Request $req)
    {
    }







    //catatan







    //Send Raport













    public function injectsiswa(Request $req)
    {
        return view("datasiswa.injectsiswa");
    }
    public function injectsiswastore(Request $req)
    {
    }

    //Siswa
    public function registersiswa(Request $req)
    {
        return view("auth.registersiswa");
    }

    public function registersiswastore(Request $req)
    {
        $req->validate([
            'nis' => ['required', 'max:255'],
            'password' => ['required', 'confirmed'],
        ]);

        //check the password
        //Update password 
        $siswa = Siswa::find($req->nis);

        if ($siswa->password != null) {
            return redirect()->back()->with("error", "Akun ini sudah memiliki kata sandi");
        }

        $siswa->password = Hash::make($req->password);
        $siswa->save();


        event(new Registered($siswa));

        Auth::guard("siswa")->login($siswa);

        Alert::success("Akun Berhasil diaktifkan", "Halo " . $siswa->nama_siswa . ", Selamat Datang di BKBN :)");

        return redirect()->route("siswa.pengajuankonseling");
    }

    public function loginsiswa(Request $req)
    {
        return view("auth.loginsiswa");
    }






    public function loginsiswaattempt(LoginRequestSiswa $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->route("siswa.pengajuankonseling");
    }

    public function logoutsiswa(Request $request)
    {
        Auth::guard('siswa')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
