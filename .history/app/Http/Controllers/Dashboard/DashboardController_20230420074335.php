<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Angkatan;
use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $req)
    {
        $kategori = Kategori::all();

        foreach($kategori as $k =>$ktg){


        }
        
    }
}
