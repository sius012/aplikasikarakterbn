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
                            <button class="btn btn-primary" style="font-size: 8pt; padding: 10px">Tanggapi</button>
                            <button class="btn btn-danger btn-reject" style="font-size: 8pt; padding: 10px" data-id="{{$rk->id_pk}}">Tolak</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push("js")
<script>
    $(document).ready(function() {
        $(".btn-reject").click(function() {
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
                        url: "/tolakreservasi",
                        type: "put"
                    })
                }
            })
        })
    })

</script>
@endpush
@endsection
