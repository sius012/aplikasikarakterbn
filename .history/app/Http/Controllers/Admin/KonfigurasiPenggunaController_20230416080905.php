<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Image;

class KonfigurasiPenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $req)
    {
        try {
            $nama = $req->nama;
            $email = $req->email;
            $password = $req->password;

            $user = new User();

            $user->name = $nama;
            $user->email = $email;
            $user->password = Hash::make($password);

            if ($req->hasFile('pp')) {
                $img = $req->file('pp');
                $imgname = time()."_".$nama.".".$img->getClientOriginalExtension();
                $path = public_path('/fpguru');
                $imageCompressed = Image::make($img->getRealPath());
                $imageCompressed->resize(100,100, function($c){
                    $c->aspectRatio();
                })->save($path, $imgname);

                $user->photo = $imgname;
            }
            
            $user->save();

            //assignrole 
            $user->assignRole($req->role);
        } catch (\Throwable $th) {
            dd()
            //throw $th;
        }
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
}
