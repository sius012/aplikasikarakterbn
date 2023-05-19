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
                        array_push($walikelas["jurusan"],explode(",",$ha->id_jurusan));
                        
                     
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
                $walikelas['jurusan']  = call_user_func_array('array_merge', $walikelas['jurusan']);

             
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

    public function entryTheClass($angkatan, $jurusan, $params = null){
        if(!regularPermission($this->getRoleNames(),["Admin","Kepala Sekolah"])){
            $hakAkses = TeacherHasTeaching::where("id_guru", $this->id)->where("dari","<", date("Y-m-d"))->where("sampai",">", date("Y-m-d"))->get();

            $angkatanListMain = [];
            $jurusanListMain = [];
            $waliKelasAngkatan = [];
            $waliKelasJurusan = [];
            $jk["L"] = [];
            $jk["L"]["angkatan"] = [];
            $jk["L"]["jurusan"] = [];

            $jk["P"] = [];
            $jk["P"]["angkatan"] = [];
            $jk["P"]["jurusan"] = [];

            $jk["S"] = [];
            $jk["S"]["angkatan"] = [];
            $jk["S"]["jurusan"] = [];
            $agama = [];


            $agAngkatan = [];
            $agJurusan = [];
            
            foreach($hakAkses as $h => $ha){
                $angkatanList = $ha->id_angkatan == "semua" ? Angkatan::get()->pluck('id_angkatan')->toArray() : explode(",",$ha->id_angkatan);
                array_push($angkatanListMain,$angkatanList);

                $jurusanList = $ha->id_jurusan == "semua" ? Jurusan::get()->pluck('id_jurusan')->toArray() : explode(",",$ha->id_jurusan);
                array_push($jurusanListMain,$jurusanList);

                if(str_contains(strtolower($ha->sebagai),"wali kelas")){
                    array_push($waliKelasAngkatan, $angkatanList);
                    array_push($waliKelasJurusan, $jurusanList);
                }

                switch ($ha->jenis_kelamin) {
                    case 'L':
                        array_push($jk["L"]["angkatan"],$angkatanList);
                        array_push($jk["L"]["jurusan"],$jurusanList);
                        break;
                    case 'P':
                        array_push($jk["P"]["angkatan"],$angkatanList);
                        array_push($jk["P"]["jurusan"],$jurusanList);
                        break;
                    default:
                       array_push($jk["S"]["angkatan"],$angkatanList);
                       array_push($jk["S"]["jurusan"],$jurusanList);
                        break;
                }

                


                //Check Agama
                if(in_array($angkatan,$angkatanList) and in_array($jurusan, $jurusanList)){
                    $agamaList = explode(",", $ha->agama);
                    if($ha->agama == "semua"){
                        $agamas = Siswa::all()->groupBy("agama");
                        $agamaList = [];
                        foreach($agamas as $i =>$ag){
                            array_push($agamaList, $i);
                        }
                        
                    }
                    array_push($agama, $agamaList);
                }

                
            }

        
            $angkatanListMain = call_user_func_array("array_merge",$angkatanListMain);
            $jurusanListMain = call_user_func_array("array_merge",$jurusanListMain);
            $waliKelasAngkatan = call_user_func_array("array_merge",$waliKelasAngkatan);
            $waliKelasJurusan = call_user_func_array("array_merge",$waliKelasJurusan);
            $agama = call_user_func_array("array_merge",$agama);



            //Check Apakah Ada Angkatan yg sesuai
            $checkAngkatan = in_array($angkatan, $angkatanListMain);
            $checkJurusan = in_array($jurusan, $jurusanListMain);
            $checkAngkatanWK = in_array($angkatan, $waliKelasAngkatan);
            $checkJurusanWK = in_array($jurusan, $waliKelasJurusan);

            //normalized
            foreach($jk as $j => $jj){
                $jk[$j]["angkatan"] = call_user_func_array("array_merge", $jk[$j]["angkatan"]);
                $jk[$j]["angkatan"] = call_user_func_array("array_merge", $jk[$j]["angkatan"]);
            }
            if($checkAngkatan and $checkJurusan and $checkAngkatanWK and $checkJurusanWK){
             
                $jks = [];
                foreach($jk as $i => $js){
                    if(in_array($angkatan, $js["angkatan"]) and in_array($jurusan, $js["jurusan"])){
                        array_push($jks, $i);
                    }
                }

                dd($jk);

               

                switch ($jks) {
                    case 'L':
                        $realJK = ["L"];
                        break;

                    case 'P':
                        $realJK = ["P"];
                         break;

                    case 'S':
                        $realJK = ["L","P"];
                         break;
                    
                    default:
                        # code...
                        break;
                }

           

                
                $siswa = Siswa::where("id_angkatan", $angkatan)->where("id_jurusan", $jurusan)->whereIn("jenis_kelamin", $realJK)->whereIn("agama", $agama);

                if(isset($params["singular"]) and isset($params["nis"])){
                    if($params["singular"] == "yes"){
                        $siswa = $siswa->where("nis", $params["nis"])->first();
                    }
                }else{
                    $siswa = $siswa->get();
                }

                if($siswa->count() < 1){
                    return false;
                }
                return $siswa;
            }else{
                return false;
            }
            
        }else{
            $siswa = Siswa::where("id_angkatan", $angkatan)->where("id_jurusan", $jurusan)->get();
            return $siswa;
        }
        
    }


    public function checkStudentProfile($nis){
        $siswa = Siswa::find($nis);
        $angkatan = $siswa->id_angkatan;
        $jurusan = $siswa->id_jurusan;

        $checkClass = $this->getMyListJurusan($angkatan, $jurusan, ["nis"=>$nis,"singular"=>"yes"]);
        
        dd($checkClass);
        
    }

}