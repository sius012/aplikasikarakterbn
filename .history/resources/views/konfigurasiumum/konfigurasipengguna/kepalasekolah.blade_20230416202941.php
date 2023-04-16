@extends('layouts.master')
@section('content')
<div class="card mb-4">
    <div class="card-header pb-0">
      <h6>Authors table</h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-uppercase text-secondary text-xxs font-weight-bolder">Sebagai</th>
              <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder ">Kelas</th>
              <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder ps-2">Jurusan</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Dari</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sampai</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
            </tr>
          </thead>  
          <tbody>
            @foreach($hakakses as $i => $ha)
            <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <p class="text-xs font-weight-bold mb-0">{{$ha->sebagai}}</p>
                  </div>
                </td>
                <td>
                  <p class="text-xs text-center text-secondary mb-0">{{$ha->angkatan->kelas()}}</p>
                </td>
                <td class="align-middle text-center text-sm">
                    <p class="text-xs text-center text-secondary mb-0">{{$ha->jurusan->jurusan}}</p>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{Carbon\Carbon::parse($ha->dari)->toDateString()}}</span>
                </td>
                <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{Carbon\Carbon::parse($ha->sampai)->toDateString()}}</span>
                </td>
                <td class="align-middle text-center">
                   <button class="btn btn-dangerk">
                        <i class="fa fa-trash"></i>
                   </button>
                </td>
              </tr>
            @endforeach
          
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-hak-akses" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalToggleLabel">Tambah Hak Akses</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route("admin.konfigurasiumum.pengguna.hak.tambah")}}" method="POST">
            @csrf
            <input type="hidden" value="{{$id}}" name="id_user">
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="" class="form-label">Sebagai</label>
                    <input type="text" class="form-control" name="sebagai">
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Angkatan dan Jurusan</label>
                    <div class="row">
                        <div class="col">
                            <select name="angkatan" id="" class="form-control" required>
                                <option value="">Angkatan</option>
                                @foreach($angkatan as  $akt)
                                    <option value="{{$akt->id_angkatan}}" @if($akt->kelas() > 12) disabled @endif>{{$akt->id_angkatan}} @if($akt->kelas() <= 12) (Kelas {{$akt->kelas()}}) @endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select name="jurusan" id="" class="form-control" required>
                                <option value="">Jurusan</option>
                                @foreach($jurusan as  $jrs)
                                    <option value="{{$jrs->id_jurusan}}" placeholder='Angkatan'>{{$jrs->jurusan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">
                        Dari
                    </label>
                    <input type="date" class="form-control" name="dari">
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">
                        Sampai
                    </label>
                    <input type="date" class="form-control" name="sampai">
                </div>
            </div>
            <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
              <button class="btn btn-primary" type="submit">Tambah</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection