@extends('layouts.mastersiswa')
@section('title', 'Riwayat Konseling Saya')
@section('content')

@foreach($riwayat as $i => $rwt)
<div class="card">
    <div class="card-header pb-0 px-3">
        <h6 class="mb-0">Riwayat Konseling saya</h6>
      </div>
      <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
              <div class="d-flex flex-column">
                <h6 class="mb-3 text-sm">Oliver Liam</h6>
                <span class="mb-2 text-xs">Company Name: <span class="text-dark font-weight-bold ms-sm-2">Viking Burrito</span></span>
                <span class="mb-2 text-xs">Email Address: <span class="text-dark ms-sm-2 font-weight-bold">oliver@burrito.com</span></span>
                <span class="text-xs">VAT Number: <span class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
              </div>
              <div class="ms-auto text-end">
                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="far fa-trash-alt me-2"></i>Delete</a>
                <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
              </div>
            </li>
        </ul>
      </div>
</div>
<div class="row mb-3">
    <div class="col-md">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm">
                        <h5>Konseling tanggal {{$rwt->tanggal}}</h5>
                    </div>
                    <div class="col-sm text-end">
                        <span class="badge {{renderStatusReservasi($rwt->status)}}">{{$rwt->status}}</span>
                    </div>
                </div>

            </div>
            <div class="card-body py-0">
                <p><b>Konselor:</b> {{$rwt->detailjk->jadwal->konselor->name}}</p>
                <p>{{$rwt->keterangan_siswa}}</p>
            </div>
            @if($rwt->status == "Dipesan")
            <div class="card-footer py-1">
                <button class="btn bg-gradient-danger btn-batalkan d-block" data-id="{{$rwt->id_bk}}"><i class="fa fa-trash " style="margin-right: 5px"></i>Batalkan</button>
            </div>
            @endif
        </div>
    </div>
</div>
@endforeach



@endsection

@push("js")
<script>
    $(document).ready(function() {
        $(".btn-batalkan").click(function() {
            var id = $(this).data("id")
            Swal.fire({
                title: 'Apakah anda ingin membatalkan konseling?'
                , showCancelButton: true
                , confirmButtonText: 'Batalkan'
                ,cancelButtonText: "Tutup"
                , denyButtonText: `Don't save`
            , }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('siswa.batalkonseling')}}",
                        data: {
                            id: id
                        },
                        type: "get",
                        success: function(){
                            window.location = "{{route('siswa.riwayatkonseling')}}";
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
