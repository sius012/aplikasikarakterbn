@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h4>Hak Akses Saya</h4>
                </div>
                <div class="col text-end">
                    <button data-bs-toggle="modal" data-bs-target="#modal-pengajuan-ha" class="btn btn-primary">Ajukan Hak Akses</button>
                </div>
            </div>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Hak Akses</th>
                            <th>Dari</th>
                            <th>Sampai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hakakses as $i => $ha) 
                        <tr>
                            <td>{{$ha->sebagai}}</td>
                            <td>{{$ha->dari}}</td>
                            <td>{{$ha->sampai}}</td>
                            <td>
                               <div class="btn-group">
                                    @if($ha->status == "await")
                                        <a class="btn btn-danger btn-sm" href="{{route('hakaksessaya.destroy')}}"><i class="fa fa-trash"></i></a>
                                    @endif
                               </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" id="modal-pengajuan-ha">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="{{route('guru.hakaksessaya.store')}}" method="POST">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title">Ajukan Hak Akses</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Anda bisa mengajukan hak akses untuk mengakses kelas tertentu</p>
              <div class="mb-3">
                <label for="" class="form-label">Sebagai</label>
                <input type="text" class="form-control" placeholder="cth(Wali Kelas, Guru Bhs. Indo, dll)" required name="sebagai">
                <span style="font-size: 8pt">Note: untuk hak akses wali kelas, anda bisa mengetikan "Wali Kelas" dikolom sebagai.</span>
              </div>
              <div class="mb-3">
                <label for="" class="form-label">Kelas</label>
                <select name="angkatan" id="" class="form-select">
                    @foreach($angkatan as $a => $akt)
                        <option value="{{$akt->id_angkatan}}" name="angkatan" required>{{$akt->kelas()}} (Angkatan {{$akt->id_angkatan}})</option>
                    @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label for="" class="form-label">Jurusan</label>
                <select name="jurusan" id="" class="form-select">
                    @foreach($jurusan as $j => $jrs)
                        <option value="{{$jrs->id_jurusan}}" name="jurusan" required>{{$jrs->jurusan}}</option>
                    @endforeach
                </select>
              </div>
              <div class="row">
                <div class="col">
                    <label for="" class="form-label">
                        Dari
                    </label>
                    <input type="date" class="form-control" name="dari" required>
                </div>
                <div class="col">
                    <label for="" class="form-label">
                        Sampai
                    </label>
                    <input type="date" class="form-control" name="sampai" required>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Ajukan</button>
            </div>
        </form>
          </div>
        </div>
      </div>
@endsection