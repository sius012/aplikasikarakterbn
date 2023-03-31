@extends('layouts.mastersiswa')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Riwayat Konseling Saya</h3>
    </div>
    <div class="card-body px-0 py-0 m-0" >
        <div class="table-responsive" style="min-height: 100vh">
            <table class="table align-items-center mb-0">
                <tbody>
                    @foreach($riwayat as $i => $rwt)
                        <tr>
                            <th colspan="2" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-8">{{$rwt->tanggal}}</th>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-8">{{$rwt->tanggal}}</th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-8">{{$rwt->tanggal}}</th>
                            <td>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection