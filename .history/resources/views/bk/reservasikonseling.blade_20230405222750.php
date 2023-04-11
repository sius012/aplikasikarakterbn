@extends('layouts.master')
@section('title', 'Laporan Konseling')
@section('branch1', 'Guru BK')
@section('branch2', 'Laporan Konseling')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Reservasi Konseling</h3>
    </div>
    
    <div class="card-body">
        
        <div class="table-responsive">
            <div class="m-3">
                <form action="">
                <table class="table">
                    <tr>
                        <td>Nama Konseli</td>
                        <td>Kelas</td>
                        <td>Hari/Tanggal</td>
                        <td>Status</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><input type="text" class="form-control" name="nama"></td>
                        <td><input type="date" class="form-control" name="dari"></td>
                        <td><input type="date" class="form-control" name="sampai"></td>
                        <td><select name="status" id="" class="form-select">
                            <option value="">Pilih Status</option>
                            <option value="Menunggu">Menunggu</option>  
                            <option value="Selesai">Selesai</option>    
                            <option value="Ditolak">Ditolak</option>      
                        </select></td>
                        <td><button class="btn btn-primary" type="submit">Cari</button></td>
                    </tr>
                </table>
            </form>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Dibuat pada</th>
                        <th>Siswa</th>
                        <th>Waktu Konseling</th>
                        <th>Keterangan Siswa</th>
                        <th>Catatan Konselor</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservasikonseling as $rk)
                    <tr>
                        <td>{{$rk->created_at}}</td>
                        <td>{{$rk->pengaju->nama_siswa}}</td>
                        <td>{{$rk->tanggal}}</td>
                  
                        <td>{{$rk->keterangan}}</td>
                        <td>@if($rk->catatan_konselor != null) {{$rk->catatan_konselor}} @else Belum ditanggapi @endif</td>
                        <td><span class="badge {{renderStatusReservasi($rk->status)}}">{{$rk->status}}</span></td>
                        <td>
                            @if($rk->status == "Menunggu")
                            <button class="btn btn-warning btn-edit" style="font-size: 8pt; padding: 10px" data-id="{{$rk->id_pk}}"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-primary btn-tanggapi" style="font-size: 8pt; padding: 10px" data-id="{{$rk->id_pk}}">Tanggapi</button>
                            <button class="btn btn-danger btn-reject" style="font-size: 8pt; padding: 10px" data-id="{{$rk->id_pk}}">Tolak</button>
                            @endif
                           
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-tanggapi" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tanggapi Reservasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('bk.tanggapireservasi')}}" method="POST">
            @csrf
            @method('put')
        <div class="modal-body">
            <input type="hidden" class="id_pk" name="id_pk">
          <div class="form-group">
            <label for="">Keterangan</label>
            <textarea name="catatan_konselor" id="" cols="30" rows="3" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Selesai</button>
        </div>
    </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-tanggal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Jadwal Reservasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('bk.ubahjadwalreservasi')}}" method="POST">
            @csrf
            @method('put')
        <div class="modal-body">
            <input type="hidden" class="id_pk" name="id_pk">
          <div class="form-group">
            <label for="">Keterangan</label>
            <input type="datetime-local" class="form-control" name="tanggal">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Ubah</button>
        </div>
    </form>
      </div>
    </div>
  </div>

@push("js")
<script>
    $(document).ready(function() {
        const modalTanggapi = new bootstrap.Modal('#modal-tanggapi', {
            keyboard: false
        })

        const modalTanggal = new bootstrap.Modal('#modal-tanggal', {
            keyboard: false
        })

        $(".btn-edit").click(function(){
            $(".id_pk").val($(this).data('id'));
            modalTanggal.show();
        })

        
        $(".btn-tanggapi").click(function(){
            $(".id_pk").val($(this).data('id'));
            modalTanggapi.show();
        })

        $(".btn-reject").click(function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Batalkan reservasi'
                , showCancelButton: true
                , showDenyButton: true
                , showConfirmButton: false
                , denyButtonText: `Batalkan`
            , }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isDenied) {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr('content')
                        },
                        url: "{{route('bk.tolakreservasi')}}",
                        data: {
                            id: id
                        },
                        type: "put",
                        success: function(){

                            window.location = "";
                        },
                        error: function(err){
                            alert(err.responseText);    
                        }
                    })
                }
            })
        })
    })

</script>
@endpush
@endsection
