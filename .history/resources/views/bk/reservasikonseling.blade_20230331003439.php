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

@push("js")
<script>
    $(document).ready(function() {
        const myModal = new bootstrap.Modal('#modal-tanggapi', {
            keyboard: false
        })

        $(".btn-tanggapi").click(function(){
            
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
