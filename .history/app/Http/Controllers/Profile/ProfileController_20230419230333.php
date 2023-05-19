<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;
use Image;
use App\Models\User;
use App\Models\UserDis;
use App\Models\TeacherHasTeaching;

class ProfileController extends Controller
{
    public function index(){
        $user = UserDis::find(Auth::user()->id);
        $hakakses = TeacherHasTeaching::where("id_guru", $user->id)->get();
        return view("profil.index2",["imagepp"=>$user->getPhotoProfile(),"hakakses"=>$hakakses]);
    }

    public function updatePP(Request $req){
        if($req->hasFile("image")){
            $nama = Auth::user()->name;
            $img = $req->file("image");
        
            $imgname = time()."_".$nama.".".$img->getClientOriginalExtension();
                    $path = public_path('photoprofile');
                    $imageCompressed = Image::make($img->getRealPath());
                    $imageCompressed->resize(200,200)->save($path."/".$imgname);

            $user = Auth::user();
            $user->fill([
                'photo' => $imgname
            ])->save();
        }else{
            
        }
        return redirect()->back();
    }

}