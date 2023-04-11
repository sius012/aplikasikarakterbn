@extends('layouts.master')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<style>
.card{
    padding: 5%;
    margin: 2em;
}
.profil{
    border-radius: 50%;
    height:2em;
    width: 2em;
    margin: 0.5em;
}
.fa-comment-o{
    font-size: 30px;
}
.card-text{
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  max-width: 300px;
}
.nomor-comment{
    margin-top: -38px;
    margin-left: 22px;
    background: red;
    border-radius: 50%;
    width: 80%;
    text-align: center;
}
.tambah{
    position: fixed;
    z-index: 1;
    margin-left: 28.5em;
    margin-top: 13em;
    border-radius: 50%;
    background: #cb0c9f !important;
    outline: none;
    border: none;
    color: white;
    width: 5%;
    font-size: 40px;
    text-align: center;
}

.overlay h2{
    font-size: 20px;
    margin-left: 5px;
}
.overlay .fa-image{
    padding: 50px;
    color: white;
    background: rgb(193, 53, 193);
    font-size: 90px;
    margin: 0 2.5em auto;
    border-radius: 10%;
    cursor: pointer;
    transition: 0.3s;
}

.fa-image:hover{
    background : purple;
}

.info .lol .tombol_post{
    width: 97%;
}


.info{
    overflow-y: sroll;
}

.overlay{
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.8);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
        z-index: 2148;
}
.overlay:target{
    visibility: visible;
    opacity: 1;
    transition: 0.3s;
}
.overlay .info input{
    margin: 5px 10px auto;
    width: 90%;
}
.overlay .info select{
    margin-left: 5px;
    width: 30em;
}
.overlay .info label{
    margin-left: 5px;
}
.info .lol{
    margin: 3% 30% auto;
    background: #fff;
    width: 40%;
    border-radius: 3px;
    padding: 10px 0;
    overflow-y: visible;
}
.lol button{
    float: right;
    margin: 10px;
}
a.keluar{
    float: right;
    color: black;
    text-decoration: none;
}
.show-hide{
   position:absolute;
   right: 3em;
   top: 66%;
   transform: translateY(-50%);
   cursor: pointer;
}

.file{
    display: none;
}

.lanjut{
    position: absolute;
    font-size: 70px;
    margin-top: 4em;
    margin-left: 14em;
    color: white;
    transition: 0.3s;
}

.detail_foto{
    height: 200px;
    margin: 5px 0px 0px 120px;
    border-radius: 5%;
}




@media(max-width: 500px) {
  .info .lol{
    margin-left: 3em;
    width: 70%;
  }
  .show-hide{
   position:absolute;
   right: 2em;
   top: 66%;
   transform: translateY(-50%);
   cursor: pointer;
}

.overlay .fa-image{
    margin-left: 0.3em;
}

.info .lol .tombol_post{
    width: 90%;
}

}



@media (max-width: 1282px) and (max-height: 802px){
   .tambah{
        margin-left: 22.3em;
        width: 5%;
        margin-top: 44%;
   }

   .overlay .fa-image{
    margin-left: 1.8em;
}

.detail_foto{
    margin: 5px 0px 0px 120px;
}
}

@media (max-width: 1025px){
   .tambah{
        margin-left: 22.7em;
        width: 7%;
        margin-top: 40%;
   }

   .overlay .fa-image{
    margin-left: 1.3em;
}
}

@media (max-width: 913px){
   .tambah{
        margin-left: 20em;
        width: 7%;
        margin-top: 120%;
   }

   .overlay .fa-image{
    margin-left: 1em;
}
}

@media (max-width: 822px){
   .tambah{
        margin-left: 17.7em;
        width: 8%;
        margin-top: 110%;
   }

   .overlay .fa-image{
    margin-left: 0.8em;
}
}

@media (max-width: 770px){
   .tambah{
        margin-left: 16.4em;
        width: 8%;
        margin-top: 110%;
   }
}

@media (max-width: 543px){
   .tambah{
        margin-left: 10.7em;
        width: 12%;
        margin-top: 90%;
   }

   .overlay .fa-image{
    margin-left: 0.1em;
}

.info .lol .tombol_post{
    width: 90%;
}
}

@media (max-width: 415px){
   .tambah{
        margin-left: 7.6em;
        width: 15%;
        margin-top: 160%;
   }

   .overlay .fa-image{
    margin-left: 0.5em;
}

}

@media (max-width: 395px){
   .tambah{
        margin-left: 7.1em;
        width: 15%;
        margin-top: 160%;
   }
}

@media (max-width: 376px){
   .tambah{
        margin-left: 6.5em;
        width: 17%;
        margin-top: 120%;
   }

   .overlay .fa-image{
    margin-left: 0.4em;
}
}

@media (max-width: 281px){
   .tambah{
        margin-left: 4.2em;
        width: 23%;
        margin-top: 150%;
   }

   .overlay .fa-image{
    padding: 10px;
    font-size: 90px;
    margin-left: 0.4em;
}
}


</style>


<div id="tambah" class="overlay">
        <div class="info">
            <div class="lol">
        <form id="upload-form" action="{{route('tambah_laporan')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_roles" value="@foreach($datas2 as $d) {{$d->role_id}}@endforeach">
        <input type="hidden" name="id_pengguna" value="@foreach($datas2 as $d) {{$d->model_id}}@endforeach">
        <h2>Post Gambar Anda<a href="#" class="keluar">&times</a></h2>
        <hr style="border: 1px solid black;margin-top: -3px;">

             <label for="file-input">
            
                 <i class="fas fa-image"></i>
                 <input type="file" id="file-input" class="file" accept="image/*" multiple name="gambar[]">
             </label>
        </form>
            </div>
        </div>
    </div>

    
    <a href="#tambah"><button type="button" class="tambah">+</button></a>

   

    @foreach($datas as $i)
        @php
            $images = explode('|', $i->gambar);
        @endphp

        <div class="card">
            <img class="profil" src="https://wallpaperset.com/w/full/c/b/e/534560.jpg"> <b style="margin-left: 3em;margin-top: -2.3em;">{{$i->pengguna->name}} ({{$i->role->name}})</b><br>
  <a href="#detail/{{$i->id_laporan}}" class="detail_gambar" post_detail="{{$i->id_laporan}}"><img class="card-img-top" src="{{asset('postingan/'.$images[0])}}" alt="Card image cap"></a>
  <div class="card-body">
    <details>
    <summary class="card-text">{{$i->deskripsi ?? "Tidak Ada Deskripsi"}}</summary>
    <p>{{$i->deskripsi}} <b>({{$i->nama_siswass ?? 'Tidak Ada Nama'}})</b></p>
</details>
  </div>
</div>


<div id="detail/{{$i->id_laporan}}" class="overlay" style="overflow-y:scroll">
    <div class="info">
            <div class="lol" >
                 <h2>Detail Post Laporan<a href="#" class="keluar">&times</a></h2>
                 @foreach($images as $img)
                 <img class="detail_foto" src="{{asset('postingan/'.$img)}}" id="detail_foto">
                 @endforeach
            </div>
        </div>
</div>
    @endforeach


        <script>
$(function() {
    $('#file-input').on('change', function() {
        
      $('#upload-form').submit();
      
    });
  });
</script>
@endsection


