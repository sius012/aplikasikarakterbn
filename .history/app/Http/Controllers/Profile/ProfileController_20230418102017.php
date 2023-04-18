<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;

class ProfileController extends Controller
{
    public function index(){
        
        return view("profil.index2");
    }

    public function updatePP(Request $req){
        if($req->hasFile("file")){
            $nama = Auth::user()->name;
        
            $imgname = time()."_".$nama.".".$img->getClientOriginalExtension();
                    $path = public_path('photoprofile');
                    $imageCompressed = Image::make($img->getRealPath());
                    $imageCompressed->resize(200,200)->save($path."/".$imgname);
        }
        }
        
}
