<div class="card card-kelas mb-3">
    <div class="card-body">
        <h5 class="card-title mt-4">Kelas</h5>
        <h1 class="mb-3">{{$labelkelas}}</h1>
        <p class="card-text mb-2">Jumlah siswa {{$jumlahsiswa}}</p>
        <a href="{{route('datajurusan',['angkatan'=>$angkatan])}}" class="btn btn-primary">Lihat <i class="bi bi-eye"></i></a>
    </div>
</div>