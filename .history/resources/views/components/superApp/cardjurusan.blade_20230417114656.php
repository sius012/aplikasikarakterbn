<div class="card m-3">
    <div class="card-body">
        <h3>{{$jrs[0]->jurusan->jurusan}}</h3>
        <p>Jumlah siswa: {{$jrs->count()}}</p>
        if($visibility){

        }
        <a class="btn btn-secondary" href="{{route("eraport.kelas", ["angkatan"=>$jrs[0]->id_angkatan, "jurusan"=>$jrs[0]->id_jurusan])}}">
            <i class="bi bi-book"></i>
        </a>
    </div>  
</div>