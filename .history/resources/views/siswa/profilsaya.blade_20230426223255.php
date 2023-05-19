@extends('layouts.mastersiswa')
@section('title', 'Profil '.ucwords($siswa->nama_siswa))
@section('branch1', 'Data Siswa')
@section('branch2', 'Profil Siswa')
<?phpbukalarik()?>
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
                <tr>
                    <th>Status</th>
                    <td>{{$siswa->status()}}</td>
                </tr>
            </table>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Profil Lengkap</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Raport Karakter</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="overflow-y: scroll; max-height: 300px">
                    <div class="card mt-3">
                        <div class="card-body px-0 py-0">
                            <div class="responsive-table px-0 py-0">
        
                                <form action="{{route('datasiswa.updatesiswa')}}" method="POST">
                                @csrf
                                @method('put')
                                <table class="table px-0 py-0">
                                    <tr>
                                        <th class="text-center" colspan="2">Data Pribadi</th>
                                    </tr>
                                    <tr>
                                        <th>NIS</th>
                                        <td><input type="number" name="nis" value="{{$siswa->nis}}" class="form-control" readonly></td>
                                    </tr>
                                    <tr>
                                        <th>Nama</th>
                                        <td><input type="text" name="nama_siswa" value="{{$siswa->nama_siswa}}" class="form-control editable-field" readonly required></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td><input type="text" name="jenis_kelamin" class="form-control editable-field " value="{{$siswa->jenis_kelamin}}" readonly></td>
                                    </tr>
                                    <tr>
                                        <th>Angkatan</th>
                                        <td>
                                            <select name="id_angkatan" id="" class="form-control editable-field" readonly>
                                                @foreach($angkatan as $akt)
                                                    <option value="{{$akt->id_angkatan}}" @if($siswa->id_angkatan == $akt->id_angkatan)  selected  @endif>{{$akt->id_angkatan}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jurusan</th>
                                        <td>
                                            <select name="id_jurusan" id="" class="form-control editable-field">
                                                @foreach($jurusan as $jrs)
                                                    <option value="{{$jrs->id_jurusan}}" @if($siswa->id_jurusan == $jrs->id_jurusan)  selected  @endif>{{$jrs->jurusan}}</option>
                                                @endforeach
                                            </select>
                                        </td>
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
                                        <td><input name="hobi" class="form-control editable-field" type="text" @if($siswa->detail->hobi == null) placeholder="Lengkapi" @else value="{{$siswa->detail->hobi}}" @endif> </td>
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
                                        <td><input type="text" name="nama_wali" class="form-control editable-field" @if($siswa->detail->nama_wali != null) value="{{$siswa->detail->nama_wali}}" readonly @else placeholder="Lengkapi" @endif></td>
                                    </tr>
                                    <tr>
                                        <th>Pekerjaan Wali</th>
                                        <td><input type="text" name="pekerjaan_wali"  class="form-control editable-field" @if($siswa->detail->pekerjaan_wali != null) value="{{$siswa->detail->pekerjaan_wali}}" readonly @else placeholder="Lengkapi" @endif>{{$siswa->pekerjaan_wali}}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Wali</th>
                                        <td><input type="text" name="alamat_wali" class="form-control editable-field" @if($siswa->detail->alamat_wali != null) value="{{$siswa->detail->alamat_wali}}" readonly @else placeholder="Lengkapi" @endif></td>
                                    </tr>
                                    <tr>
                                        <th>No.Telp Wali</th>
                                        <td><input type="text" name="telp_wali" class="form-control editable-field" @if($siswa->detail->telp_wali != null) value="{{$siswa->detail->telp_wali}}" readonly @else placeholder="Lengkapi" @endif></td>
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
                                        <th><input type="text" name="alamat" class="form-control editable-field" @if($siswa->alamat->alamat != null) value="{{$siswa->alamat->alamat}}" readonly @else placeholder="Lengkapi" @endif ></th>
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
                                            <input type="text" name="dusun" class="form-control editable-field" @if($siswa->alamat->dusun != null) value="{{$siswa->alamat->dusun}}" readonly @else placeholder="Lengkapi" @endif>
                                           </th>
                                    </tr>
                                    <tr>
                                        <th>Kelurahan</th>
                                        <th><input type="text" name="kelurahan" class="form-control editable-field" @if($siswa->alamat->kelurahan != null) value="{{$siswa->alamat->kelurahan}}" readonly @else placeholder="Lengkapi" @endif></th>
                                    </tr>
                                    <tr>
                                        <th>Kecamatan</th>
                                        <th><input type="text" name="kecamatan" class="form-control editable-field" @if($siswa->alamat->kecamatan != null) value="{{$siswa->alamat->kecamatan}}" readonly @else placeholder="Lengkapi" @endif></th>
                                    </tr>
                                    <tr>
                                        <th>Kode Pos</th>
                                        <th><input type="text" name="kode_pos" class="form-control editable-field" @if($siswa->alamat->kode_pos != null) value="{{$siswa->alamat->kode_pos}}" readonly @else placeholder="Lengkapi" @endif></th>
                                    </tr>
                                </table>
                                 </form>
                            </div>
                        </div>
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
