<div class="card m-3">
    <div class="card-body">
        <h3>{{$jrs->jurusan}}</h3>
        <p>Jumlah siswa: {{$jrs->count()}}</p>
        @if($visibility)
            <a class="btn btn-primary" href="{{route("siswakelas", ["angkatan"=>$jrs->id_angkatan, "jurusan"=>4])}}">
                <i class="bi bi-eye"></i>
            </a>
        @endif
        <a class="btn btn-secondary" href="{{route("eraport.kelas", ["angkatan"=>$jrs->id_angkatan, "jurusan"=>4)}}">
            <i class="bi bi-book"></i>
        </a>
    </div>  
</div>