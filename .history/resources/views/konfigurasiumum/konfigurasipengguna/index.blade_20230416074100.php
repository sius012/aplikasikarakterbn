@extends('layouts.master')
@section('title', 'Konfigurasi Pengguna')
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col"> <h4>Daftar Pengguna KarakterKuy</h4></div>
            <div class="col text-end"><button class="btn btn-primary text-left" data-bs-toggle="modal" data-bs-target="#modal-user">Tambah Pengguna</button></div>
        </div>
       
    </div>
    <div class="card-body px-0 py-0">
        <table class="table align-items-center p-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Sebagai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user as $i => $usr)
                    <tr>
                        <td></td>
                        <td>{{$usr->name}}</td>
                        <td>
                            @foreach($usr->getRoleNames() as $roles)
                                {{$roles}}
                            @endforeach
                            </td>
                        <td>
                            <a href="{{route("admin.konfigurasiumum.pengguna.hak", ["id"=>$usr->id])}}"><button class="btn btn-link text-secondary mb-0">
                                <i class="fa fa-ellipsis-v text-xs"></i>
                              </button></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="modal-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="">

        </form>
        
      </div>
    </div>
  </div>

@endsection