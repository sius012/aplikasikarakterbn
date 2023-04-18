<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class ProfileController extends Controller
{
    public function index(){
        
        return view("profil.index2");
    }

    public function updatePP(){
        $nama = 
        $imgname = time()."_".$nama.".".$img->getClientOriginalExtension();
                $path = public_path('photoprofile');
                $imageCompressed = Image::make($img->getRealPath());
                $imageCompressed->resize(200,200)->save($path."/".$imgname);
    }
}
