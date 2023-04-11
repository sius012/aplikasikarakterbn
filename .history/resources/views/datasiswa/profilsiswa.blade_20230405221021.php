@extends('layouts.master')
@section('title', 'Profil '.ucwords($siswa->nama_siswa))
@section('branch1', 'Data Siswa')
@section('branch2', 'Profil Siswa')

@section('content')
<div class="row">
    <div class="col-sm-4">
        <img src="{{$siswa->getImageUrl()}}" alt="" class="img-fluid">
    </div>
    <div class="col-sm-8">
        <div class="container">
            <h3>{{$siswa->nama_siswa}}</h3>
            <table class="table">
                <tr>
                    <th>Kelas</th>
                    <td>{{$siswa->kelasdanjurusan()}}</td>
                </tr>
            </table>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Profil Lengkap</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Raport Karakter</button>
                    @if(in_array("Guru BK", Auth::user()->getRoleNames()->toArray())) <button class="nav-link" id="nav-rk-tab" data-bs-toggle="tab" data-bs-target="#nav-rk" type="button" role="tab" aria-controls="nav-rk" aria-selected="false">Riwayat Konseling</button> @endif
                    @if(in_array( Auth::user()->getRoleNames()->first(), ["Pamong Putra","Pamong Putri", "Kesiswaan", "Kepala Sekolah","Admin"])) <button class="nav-link" id="nav-catatanasrama-tab" data-bs-toggle="tab" data-bs-target="#nav-catatanasrama" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Riwayat Perilaku</button> @endif
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="overflow-y: scroll; max-height: 300px">
                    <div class="card mt-3">
                        <div class="card-body px-0 py-0">
                            <div class="responsive-table px-0 py-0">
                                <table class="table px-0 py-0">
                                    <tr>
                                        <th class="text-center" colspan="2">Data Pribadi</th>
                                    </tr>
                                    <tr>
                                        <th>NIS</th>
                                        <td>{{$siswa->nis}}</td>
                                    </tr>
                                    <tr>
                                        <th>NISN</th>
                                        <td>{{$siswa->nisn}}</td>
                                    </tr>
                                    <tr>
                                        <th>NIK</th>
                                        <td>{{$siswa->detail->nik}}</td>
                                    </tr>
                                    <tr>
                                        <th>Agama</th>
                                        <td>{{$siswa->agama}}</td>
                                    </tr>
                                    <tr>
                                        <th>Hobi</th>
                                        <td>{{$siswa->detail->hobi}}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-center">Data Orang Tua</th>
                                    </tr>
                                    <tr>
                                        <th>Nama Ayah</th>
                                        <td>{{$siswa->detail->nama_ayah}}</td>
                                    </tr>
                                    <tr>
                                        <th>Pekerjaan Ayah</th>
                                        <td>{{$siswa->pekerjaan_ayah}}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Ayah</th>
                                        <td>{{$siswa->alamat_ayah}}</td>
                                    </tr>
                                    <tr>
                                        <th>No.Telp Ayah</th>
                                        <td>{{$siswa->telp_ayah}}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Ibu</th>
                                        <td>{{$siswa->detail->nama_ibu}}</td>
                                    </tr>
                                    <tr>
                                        <th>Pekerjaan Ibu</th>
                                        <td>{{$siswa->pekerjaan_ibu}}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Ibu</th>
                                        <td>{{$siswa->alamat_ibu}}</td>
                                    </tr>
                                    <tr>
                                        <th>No.Telp Ibu</th>
                                        <td>{{$siswa->telp_ibu}}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Wali</th>
                                        <td>{{$siswa->detail->nama_wali}}</td>
                                    </tr>
                                    <tr>
                                        <th>Pekerjaan Ibu</th>
                                        <td>{{$siswa->pekerjaan_wali}}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Ibu</th>
                                        <td>{{$siswa->alamat_wali}}</td>
                                    </tr>
                                    <tr>
                                        <th>No.Telp Ibu</th>
                                        <td>{{$siswa->telp_wali}}</td>
                                    </tr>
                                    <tr>
                                        <th>Hubungan dengan Wali</th>
                                        <td>{{$siswa->hub_Wali}}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-center">Alamat Lengkap Siswa</th>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <th>{{$siswa->alamat->alamat}}</th>
                                    </tr>
                                    <tr>
                                        <th>RT/RW</th>
                                        <th>{{$siswa->alamat->rt}}/{{$siswa->alamat->rw}}</th>
                                    </tr>
                                    <tr>
                                        <th>Dusun</th>
                                        <th>{{$siswa->alamat->dusun}}</th>
                                    </tr>
                                    <tr>
                                        <th>Kelurahan</th>
                                        <th>{{$siswa->alamat->kelurahan}}</th>
                                    </tr>
                                    <tr>
                                        <th>Kecamatan</th>
                                        <th>{{$siswa->alamat->kecamatan}}</th>
                                    </tr>
                                    <tr>
                                        <th>Kode Pos</th>
                                        <th>{{$siswa->alamat->kode_pos}}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="card mt-3" style="">
                        <div class="card-header pb-0">
                            <h6 class="mb-0">Catatan Raport Karakter</h6>
                        </div>
                        <div class="card-body ">
                            <ul class="list-group">

                                    @foreach($catataneraport as $ce)
                                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                        <div class="d-flex flex-column">
                                          <h6 class="mb-3 text-sm">$ce->keterangan</h6>
                                          <span class="mb-2 text-xs">Tanggal Penilaian: <span class="text-dark font-weight-bold ms-sm-2">Viking Burrito</span></span>
                                          <span class="mb-2 text-xs">Email Address: <span class="text-dark ms-sm-2 font-weight-bold">oliver@burrito.com</span></span>
                                          <span class="text-xs">VAT Number: <span class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
                                        </div>
                                        <div class="ms-auto text-end">
                                          <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="far fa-trash-alt me-2"></i>Delete</a>
                                          <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
                                        </div>
                                      </li>
                                    

                                    @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-catatanpositif" role="tabpanel" aria-labelledby="nav-contact-tab">
                    @foreach($catatanPositif as $i => $cs)
                    @include('components.superApp.cardcatatanlist')
                    @endforeach
                </div>
                <div class="tab-pane fade" id="nav-rk" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6 class="mb-0">Riwayat Konseling</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($riwayatkonseling as $i => $rwt)
                                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-3 text-sm">{{$rwt->keterangan_siswa}}</h6>
                                        <span class="mb-2 text-xs">Hari/Tanggal: <span class="text-dark font-weight-bold ms-sm-2">{{getDates($rwt->detailjk->hari,$rwt->detailjk->jadwal->minggu,$rwt->detailjk->jadwal->bulan,$rwt->detailjk->jadwal->tahun,"hari")}} , {{getDates($rwt->detailjk->hari,$rwt->detailjk->jadwal->minggu,$rwt->detailjk->jadwal->bulan,$rwt->detailjk->jadwal->tahun)}}</span></span>
                                        <span class="mb-2 text-xs">Jam: <span class="text-dark ms-sm-2 font-weight-bold">{{$rwt->detailjk->dari}} - {{$rwt->detailjk->sampai}}</span></span>
                                        <span class="mb-2 text-xs">Konselor: <span class="text-dark ms-sm-2 font-weight-bold">{{$rwt->detailjk->jadwal->konselor->name}}</span></span>
                                        <span class="mb-2 text-xs">Catatan Konselor: <span class="text-dark ms-sm-2 font-weight-bold">{{$rwt->catatan_konselor}}</span></span>
                                        <span class="text-xs">Status: <span class="badge {{renderStatusReservasi($rwt->status)}}">{{$rwt->status}}</span></span>
                                    </div>
                                    <div class="ms-auto text-end">
                                    </div>

                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
