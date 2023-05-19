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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hakakses as $i => $ha) 
                        <tr>
                            <td>{{$ha->sebagai}}</td>
                            <td>{{$ha->dari}}</td>
                            <td>{{$ha->sampai}}</td>
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
            <div class="modal-header">
              <h5 class="modal-title">Ajukan Hak Akses</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Anda bisa mengajukan hak akses untuk mengakses kelas tertentu</p>
              <div class="mb-3">
                <label for="" class="form-label">Sebagai</label>
                <input type="text" class="form-control" placeholder="cth(Wali Kelas, Guru Bhs. Indo, dll)">
                <span style="font-size: 8pt">Note: untuk hak akses wali kelas, anda bisa mengetikan "Wali Kelas" dikolom sebagai.</span>
              </div>
              <div class="mb-3">
                <label for="" class="form-label">Angkatan</label>
                <select name="" id="" class="form-select">
                    @foreach($angkatan as $a => $akt)
                        <option value="{{$akt->id_angkatan}}">{{$akt->id_angkatan}}</option>
                    @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label for="" class="form-label">Jurusan</label>
                <select name="" id="" class="form-select">
                    @foreach($jurusan as $j => $jrs)
                        <option value="{{$jrs->id_jurusan}}"></option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
@endsection