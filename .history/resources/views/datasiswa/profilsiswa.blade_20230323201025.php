@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-sm-3 d-flex">
        <img src="https://photowhoa.com/2015/wp-content/uploads/2016/08/photo-1523913507744-1970fd11e9ff.jpg" alt="" class="rounded-circle mx-auto my-5" style="height: 200px; width: 200px; object-fit: cover">
    </div>
    <div class="col-sm-9">
        <div class="container p-5">
            <h1 class="display-6">{{$siswa->nama_siswa}}</h1>
            <table class="table borderles">
                <tr>
                    <td>Kelas</td>
                    <td>Jurusan</td>
                    <td>Angkatan</td>
                </tr>
                <tr>
                    <td>{{$siswa->kelas()}}</td>
                    <td>{{$siswa->jurusan->jurusan}}</td>
                    <td>{{$siswa->angkatan->id_angkatan}}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Perkembangan</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Pelanggaran</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Profil</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                @php
                $kategori = $kategori_positif;
                $perilaku = "Positif";
                @endphp
                @include("components.superApp.cardcatatanform")
                <div class="container">
                    @foreach($catatan_positif as $i => $cs)
                    @include('components.superApp.cardcatatanlist')
                    @endforeach

                </div>



            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                @php
                $kategori = $kategori_negatif;
                $perilaku = "Negatif";
                @endphp
                @include("components.superApp.cardcatatanform")

                @foreach($catatan_negatif as $i => $cs)
                @include('components.superApp.cardcatatanlist')
                @endforeach

            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
        </div>
    </div>
</div>

@endsection
