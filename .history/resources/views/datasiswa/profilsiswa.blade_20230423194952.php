@extends('layouts.master')
@section('title', 'Profil '.ucwords($siswa->nama_siswa))
@section('branch1', 'Data Siswa')
@section('branch2', 'Profil Siswa')

@section('content')
<div class="row">
    <div class="col-sm-4">
        <img src="{{$siswa->getImageUrl()}}" alt="" class="img-fluid">
        <form action="{{route('datasiswa.updatepp')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="fileInput">@if($siswa->foto_profil != null) Perbarui Foto Profil @else Lengkapi Foto Profil @endif</label>
        <input type="hidden" value="{{$siswa->nis}}" name="nis">
        <input type="file" id="fileInput" name="pp" accept=".jpg, .png" class="form-control mb-2">
        <button type="submit" class="btn btn-primary">@if($siswa->foto_profil != null) Perbarui @else Lengkapi @endif</button>
    </form>
    </div>
    <div class="col-sm-8">
        <div class="container">
            <h3>{{$siswa->nama_siswa}}</h3>
            <table class="table">
                <tr>
                    <th>Kelas</th>
                    <td>{{$siswa->kelasdanjurusan()}}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{$siswa->status()}}</td>
                    <td class="d-flex">
                        @php
                            $status = ["text"=>"Nonaktifkan", "btn"=>"btn-danger"];
                            if($siswa->status() == "Non-aktif"){
                                $status = ["text"=>"Aktifkan", "btn"=>"btn-success"];
                            }
                        @endphp
                        @if($siswa->status() != "Alumni")
                        <form action="{{route('datasiswa.switch')}}" method="POST" class="p-1">
                        @csrf
                        <input type="hidden" value="{{$siswa->nis}}" name="nis">
                        <button type="submit" class="btn {{$status['btn']}}">{{$status['text']}}</button>
                        </form>
                        
                        <form action="{{route('datasiswa.turunkan')}}" method="POST" class="p-1">
                            @csrf
                            @method('put')
                            <input type="hidden" value="{{$siswa->nis}}" name="nis">
                            <button type="submit" class="btn btn-danger">Turun kelas</button>
                        </form>
                        @endif
                    </td>
                </tr>
            </table>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Profil Lengkap</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Raport Karakter</button>
                    @if(regularPermission( Auth::user()->getRoleNames()->toArray(),["Admin"])) <button class="nav-link" id="nav-rk-tab" data-bs-toggle="tab" data-bs-target="#nav-rk" type="button" role="tab" aria-controls="nav-rk" aria-selected="false">Riwayat Konseling</button> @endif
                    @if(in_array( Auth::user()->getRoleNames()->first(), ["Pamong Putra","Pamong Putri", "Kesiswaan", "Kepala Sekolah","Admin","Guru BK"])) <button class="nav-link" id="nav-catatanasrama-tab" data-bs-toggle="tab" data-bs-target="#nav-rp    " type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Riwayat Perilaku</button> @endif
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="overflow-y: scroll; max-height: 300px">
                    <div class="card mt-3">
                        <div class="card-body px-0 py-0">
                            <div class="responsive-table px-0 py-0">
                                <button class="btn bg-gradient-warning edit-field"><i class="fa fa-edit"></i></button>
                                <form action="{{route('datasiswa.updatesiswa')}}" method="POST">
                                @csrf
                                @method('put')
                                <table class="table px-0 py-0">
                                    <tr>
                                        <th class="text-center" colspan="2">Data Pribadi</th>
                                    </tr>
                                    <tr>
                                        <th>NIS</th>
                                        <td><input type="number" value="{{$siswa->nis}}" class="form-control" readonly></td>
                                    </tr>
                                    <tr>
                                        <th>NISN</th>
                                        <td><input type="number" name="nisn" class="form-control editable-field " value="{{$siswa->nisn}}" readonly></td>
                                    </tr>
                                    <tr>
                                        <th>NIK</th>
                                        <td><input type="number" name="nik" class="form-control editable-field editable-field" value="{{$siswa->detail->nik}}" readonly></td>
                                    </tr>
                                    <tr>
                                        <th>TTL</th>
                                       
                                        <td>
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" name="tempat_lahir" class="form-control editable-field" value="{{$siswa->tempat_lahir}}" readonly>
                                                </div>
                                                <div class="col">
                                                    <input type="date" name="tanggal_lahir" class="form-control editable-field" value="{{$siswa->tanggal_lahir}}" readonly>
                                                </div>
                                            </div>
                                            </td>
                                    </tr>
                                    <tr>
                                        <th>Agama</th>
                                        <td><input type="text" name="agama" class="form-control editable-field" value="{{$siswa->agama}}" readonly></td>
                                    </tr>
                                    <tr>
                                        <th>Hobi</th>
                                        <td><input name="hobi" class="form-control editable-field" type="text" @if($siswa->detail->hobi == null) placeholder="Lengkapi" @else {{$siswa->detail->hobi}} @endif> </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2"  class="text-center">Data Orang Tua</th>
                                    </tr>
                                    <tr>
                                        <th>Nama Ayah</th>
                                        <td><input type="text" name="nama_ayah" @if($siswa->detail->nama_ayah == null)  placeholder="lengkapi" @else value="{{$siswa->detail->nama_ayah}}" readonly @endif class="form-control editable-field"></td>
                                    </tr>
                                    <tr>
                                        <th>Pekerjaan Ayah</th>
                                        <td><input type="text" name="pekerjaan_ayah" class="form-control editable-field" @if($siswa->detail->pekerjaan_ayah != null) readonly  value="{{$siswa->detail->pekerjaan_ayah}}" @else placeholder="Lengkapi" @endif> </td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Ayah</th>
                                        <td><input type="text" name="alamat_ayah" class="form-control editable-field" @if($siswa->detail->alamat_ayah != null)  readonly value="{{$siswa->detail->alamat_ayah}}" @else placeholder="lengkapi" @endif></td>
                                    </tr>
                                    <tr>
                                        <th>No.Telp Ayah</th>
                                        <td><input type="text" name="telp_ayah" class="form-control editable-field" @if($siswa->detail->telp_ayah != null) value="{{$siswa->detail->telp_ayah}}" readonly @else placeholder="Lengkapi"  @endif class="form-control editable-field">{{$siswa->telp_ayah}}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Ibu</th>
                                        <td><input type="text" name="nama_ibu" class="form-control editable-field" @if($siswa->detail->nama_ibu != null ) value="{{$siswa->detail->nama_ibu}}" readonly @else placeholder="Lengkapi" @endif></td>
                                    </tr>
                                    <tr>
                                        <th>Pekerjaan Ibu</th>
                                        <td><input type="text" name="pekerjaan_ibu" class="form-control editable-field" @if($siswa->detail->pekerjaan_ibu != null) value="{{$siswa->detail->pekerjaan_ibu}}" readonly @else placeholder="Lengkapi" @endif>{{$siswa->pekerjaan_ibu}}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Ibu</th>
                                        <td><input type="text" name="alamat_ibu" class="form-control editable-field" @if($siswa->detail->alamat_ibu != null) value="{{$siswa->detail->alamat_ibu}}" readonly @else placeholder="Lengkapi"  @endif>{{$siswa->alamat_ibu}}</td>
                                    </tr>
                                    <tr>
                                        <th>No.Telp Ibu</th>
                                        <td><input type="text" name="telp_ibu" class="form-control editable-field" @if($siswa->detail->telp_ibu != null)  value="{{$siswa->detail->telp_ibu}}" readonly @else placeholder="Lengkapi" @endif>{{$siswa->telp_ibu}}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Wali</th>
                                        <td><input type="text" name="nama_wali" class="form-control editable-field" @if($siswa->detail->nama_wali != null) value="{{$siswa->detail->nama_wali}}" readonly @else placeholder="Lengkapi" @endif>{{$siswa->detail->nama_wali}}</td>
                                    </tr>
                                    <tr>
                                        <th>Pekerjaan Wali</th>
                                        <td><input type="text" name="pekerjaan_wali"  class="form-control editable-field" @if($siswa->detail->pekerjaan_wali != null) value="{{$siswa->detail->pekerjaan_wali}}" readonly @else placeholder="Lengkapi" @endif>{{$siswa->pekerjaan_wali}}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Wali</th>
                                        <td><input type="text" name="alamat_wali" class="form-control editable-field" @if($siswa->detail->alamat_wali != null) value="{{$siswa->alamat_wali}}" readonly @else placeholder="Lengkapi" @endif></td>
                                    </tr>
                                    <tr>
                                        <th>No.Telp Wali</th>
                                        <td><input type="number" name="telp_wali" class="form-control editable-field" @if($siswa->detail->telp_wali != null) value="{{$siswa->telp_wali}}" readonly @else placeholder="Lengkapi" @endif></td>
                                    </tr>
                                    <tr>
                                        <th>Hubungan dengan Wali</th>
                                        <td><input type="text" name="hub_wali" class="form-control editable-field" @if($siswa->detail->telp_wali != null) value="{{$siswa->detail->hub_wali}}" readonly @else placeholder="Lengkapi" @endif>{{$siswa->hub_Wali}}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-center">Alamat Lengkap Siswa</th>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <th><input type="text" name="alamat" class="form-control editable-field" @if($siswa->alamat->alamat != null) value="{{$siswa->detail->alamat}}" readonly @else placeholder="Lengkapi" @endif ></th>
                                    </tr>
                                    <tr>
                                        <th>RT/RW</th>
                                       
                                        <th>
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" name="rt" class="form-control editable-field" @if($siswa->alamat->rt != null) value="{{$siswa->alamat->rt}}" readonly @else placeholder="Lengkapi" @endif>
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="rw" class="form-control editable-field" @if($siswa->alamat->rw != null) value="{{$siswa->alamat->rw}}" readonly @else placeholder="Lengkapi" @endif>
                                                </div>
                                            </div>
                                          </th>
                                    </tr>
                                    <tr>
                                        <th>Dusun</th>
                                        <th>
                                            <input type="text" name="" class="form-control editable-field" @if($siswa->alamat->dusun != null) value="{{$siswa->alamat->dusun}}" readonly @else placeholder="Lengkapi" @endif>
                                           </th>
                                    </tr>
                                    <tr>
                                        <th>Kelurahan</th>
                                        <th><input type="text" class="form-control editable-field" @if($siswa->alamat->kelurahan != null) value="{{$siswa->alamat->kelurahan}}" readonly @else placeholder="Lengkapi" @endif></th>
                                    </tr>
                                    <tr>
                                        <th>Kecamatan</th>
                                        <th><input type="text" class="form-control editable-field" @if($siswa->alamat->kecamatan != null) value="{{$siswa->alamat->kecamatan}}" readonly @else placeholder="Lengkapi" @endif></th>
                                    </tr>
                                    <tr>
                                        <th>Kode Pos</th>
                                        <th><input type="text" class="form-control editable-field" @if($siswa->alamat->kode_pos != null) value="{{$siswa->alamat->kode_pos}}" readonly @else placeholder="Lengkapi" @endif></th>
                                    </tr>
                                </table>
                                <button class="btn btn-primary">Perbarui</button>
                                 </form>
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
                                          <h6 class="mb-3 text-sm">{{$ce->keterangan}}</h6>
                                          <span class="mb-2 text-xs">Tanggal Penilaian: <span class="text-dark font-weight-bold ms-sm-2">{{$ce->parent->tanggal_penilaian}}</span></span>
                                          <span class="mb-2 text-xs">Kasus: 
                                            <br>
                                            @foreach($ce->aspek_dpg as $i => $adpg)
                                                {{$adpg->aspek4b->keterangan}}<br>
                                            @endforeach
                                          </span>
                                          <span class="text-xs">Keterangan: <span class="text-dark ms-sm-2 font-weight-bold">{{$ce->keterangan}}</span></span>
                                          <span class="text-xs">Follow Up: <span class="text-dark ms-sm-2 font-weight-bold">{{$ce->followup}}</span></span>
                                        </div>
                                      </li>
                                    

                                    @endforeach
                            </ul>
                        </div>
                    </div>
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
                <div class="tab-pane fade" id="nav-rp" role="tabpanel">
                    <div class="container mt-3">
                        @foreach($catatanAsrama as $i => $ca)
                        <div class="card" >
                            <div class="row">
                                <div class="col-3">
                                    <img style="width: 100%; border-radius: 30px; height: 100%; object-fit:cover" class="shadow"  src="{{$ca->lampiran->first()->getPath()}}" alt="">
                                   
                                </div>
                                <div class="col">
                                    <div class="card-body">
                                        <h5 class="card-title">{{$ca->keterangan}}</h5>
                                        <details>
                                            <summary>Aspek terkait</summary>
                                            <p class="@if($ca->kategori->tindakan == 'Negatif') text-danger @else text-success @endif">@foreach($ca->kategori->aspekTerkait() as $i => $at)
                                                <b>{{$at->point}}</b><br>
                                                {{$at->keterangan}}
                                                <br>
                                                <br>
                                            @endforeach</p>
                                          </details>
                                        <p>Kategori: <b>{{$ca->Kategori->kategori}}</b></p>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        @endforeach
                       
                      </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push("js")
<script>
    $(document).ready(function(){
        $(".edit-field").click(function(){
            $(".editable-field").each(function(){
                //alert('tes');
                if($(this).prop("readonly")){
                   
                    $(this).removeAttr("readonly");
                }else{
                    //alert('tes');
                    $(this).attr("readonly","readonly");
                    
                }
            })
        })
    })
</script>

@endpush
@endsection
