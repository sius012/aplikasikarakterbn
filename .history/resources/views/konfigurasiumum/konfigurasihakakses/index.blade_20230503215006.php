@extends("layouts.master")
@section('title', 'Konfigurasi hak akses')
@section('branch1', 'Konfigurasi Umum')
@section('branch2', 'Hak Akses')
@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row">
            <div class="col"><h4>Hak Akses</h4></div>
            <div class="col text-end">
                <button class="btn btn-primary m-1" data- data-bs-target="#tambah-hak-akses">Tambah</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="responsive-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Hak Akses</th>
                        <th>Pengguna</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

Copy
<div class="modal fade" tabindex="-1" id="tambah-hak-akses">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection