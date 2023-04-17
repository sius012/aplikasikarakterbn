<?php

namespace App\Http\Controllers\KonfigurasiUmum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KonfigurasiController extends Controller
{
    public function index(Request $req)
    {
        return view("konfigurasiumum.index");
    }
}
