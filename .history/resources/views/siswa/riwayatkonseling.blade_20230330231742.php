@extends('layouts.mastersiswa')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Riwayat Konseling Saya</h3>
    </div>
    <div class="card-body px-0 py-0 m-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal Konseling</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayat as $i => $rwt)
                        <tr>
                            <td>{{$rwt->tanggal}}</td>
                            <td>{{$rwt->keterangan}}</td>
                            <td><span class="btn {{}}"></span> </></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection