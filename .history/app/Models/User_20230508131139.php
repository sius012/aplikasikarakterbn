<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, hasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    

    public $timestamps = false;

    /**
     * The attributes that appends to returned entities.
     *
     * @var array
     */
  

    /**
     * The getter that return accessible URL for user photo.
     *
     * @var array
     */
    public function getPhotoAttribute()
    {
        // if ($this->foto !== null) {
        //     return url('media/user/' . $this->id . '/' . $this->foto);
        // } else {
        //     return url('media-example/no-image.png');
        // }
    }

    public function getMyListClass(){
        //mendapatkan hak akses
        if(!regularPermission($this->getRoleNames(),["Admin","Kepala Sekolah"])){
            $hakAkses = TeacherHasTeaching::where("id_guru", $this->id)->where("dari","<", date("Y-m-d"))->where("sampai",">", date("Y-m-d"))->get();
            $semua = false;
            //jika ada hak akses
            if($hakAkses->count() > 0){
                //
                $angkatan = [];
                foreach ($hakAkses as $i => $ha) {
                    if($ha->id_angkatan!="semua"){
                        array_push($angkatan, explode(",",$ha->id_angkatan));
                    }else{
                        $semua = true;
                    }
                }

                
                
                if($semua == false){
                    $merged_array = call_user_func_array('array_merge', $angkatan);
                    $unique_array = array_unique($merged_array);
                    $angkatan = Angkatan::whereIn("id_angkatan",$unique_array);
                    return $angkatan;
                }else{
                    return Angkatan::aktif()->get();
                }
            }
        }else{
            return Angkatan::aktif()->get();
        }
    }

    public function getMyListJurusan($akt){
        if(!regularPermission($this->getRoleNames(),["Admin","Kepala Sekolah"])){
            $hakAkses = TeacherHasTeaching::where("id_guru", $this->id)->where("dari","<", date("Y-m-d"))->where("sampai",">", date("Y-m-d"))->get();

            $semua = false;

            $walikelas['angkatan'] = [];
            $walikelas['jurusan'] = [];
            //jika ada hak akses
            if($hakAkses->count() > 0){
                //
                $jurusan = [];
                foreach ($hakAkses as $i => $ha) {
                    if($ha->id_jurusan!="semua"){
                        array_push($jurusan, explode(",",$ha->id_jurusan));
                    }else{
                        $semua = true;
                    }
    
                    if(str_contains(strtolower($ha->sebagai),"wali kelas")){

                        array_push($walikelas["angkatan"],explode(",",$ha->id_angkatan));
                        $walikelas["jurusan"] = explode(",",$ha->id_jurusan);
                    }
                }
               

                if($semua == false){
                    $merged_array = call_user_func_array('array_merge', $jurusan);
                    $unique_array = array_unique($merged_array);
                    $jurusan = Angkatan::whereIn("id_angkatan",$unique_array);
                    
                }else{
                    $jurusan =  Jurusan::whereHas("siswa", function($q) use($akt){
                        $q->where("id_angkatan", $akt);
                    })->get();
                }

                $walikelas['angkatan']  = call_user_func_array('array_merge', $walikelas['angkatan']);

                $jurusan = $jurusan->map(function($q) use($walikelas, $akt){
                    if(count($walikelas['angkatan']) > 0 and count($walikelas['jurusan']) > 0){
                        $checkAngkatan = in_array($akt,$walikelas['angkatan'],);
                        $checkJurusan = in_array($q->id_jurusan,$walikelas['jurusan']);
                       
                        if($checkAngkatan and $checkJurusan){
                            $q->visibility = true;
                        }else{
                            $q->visibility = false;
                        }
                    }else{
                        $q->visibility = false;
                    }
                    return $q;
                });



                //dd($walikelas);
               
                return $jurusan;
            }
            
        }else{
            $jurusan = Jurusan::whereHas("siswa", function($q) use($akt){
                $q->where("id_angkatan", $akt);
            })->get();

            $jurusan = $jurusan->map(function($e){
                $e->visibility = true;
                return $e;
            });

            return $jurusan;
        }
    }

    public function entryTheClass($angkatan, $jurusan){
        if(!regularPermission($this->getRoleNames(),["Admin","Kepala Sekolah"])){
            $hakAkses = TeacherHasTeaching::where("id_guru", $this->id)->where("dari","<", date("Y-m-d"))->where("sampai",">", date("Y-m-d"))->get();

            $angkatanListMain = [];
            $jurusanListMain = [];
            $waliKelasAngkatan = [];
            $waliKelasJurusan = [];
            
            foreach($hakAkses as $h => $ha){
                $angkatanList = $ha->id_angkatan == "semua" ? Angkatan::get()->pluck('id_angkatan')->toArray() : explode(",",$ha->id_angkatan);
                array_push($angkatanListMain,$angkatanList);

                $jurusanList = $ha->id_jurusan == "semua" ? Jurusan::get()->pluck('id_jurusan')->toArray() : explode(",",$ha->id_jurusan);
                array_push($jurusanListMain,$jurusanList);

                if(str_contains(strtolower($ha->sebagai),"wali kelas")){
                    array_push($waliKelasAngkatan, $angkatanList);
                    array_push($waliKelasJurusan, $jurusanList);
                }
            }

        
            $angkatanListMain = call_user_func_array("array_merge",$angkatanListMain);
            $jurusanListMain = call_user_func_array("array_merge",$jurusanListMain);

            //Check Apakah Ada Angkatan yg sesuai
            $checkAngkatan = in_array($angkatan, $angkatanListMain);
            $checkJurusan = in_array($jurusan, $jurusanListMain);
            $checkWaliKelasA = in_array()


            if($checkAngkatan and $checkJurusan){
                
            }else{
                return false;
            }
            
        }
    }

}