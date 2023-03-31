@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Reservasi Konseling</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Dibuat pada</th>
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
                        <td>{{$rk->tanggal}}</td>
                        <td>{{$rk->keterangan}}</td>
                        <td>@if($rk->catatan_konselor != null) $rk->catatan_konselor @else Belum ditanggapi @endif</td>
                        <td><span class="badge {{renderStatusReservasi($rk->status)}}">{{$rk->status}}</span></td>
                        <td>
                            @if($rk->status == "Menunggu")
                            <button class="btn btn-warning"><i class="fa fa-edit"></i></button>
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
        <form action="">
        <div class="modal-body">
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

@push("js")
<script>
    $(document).ready(function() {
        const modalTanggapi = new bootstrap.Modal('#modal-tanggapi', {
            keyboard: false
        })

        $(".btn-tanggapi").click(function(){
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
