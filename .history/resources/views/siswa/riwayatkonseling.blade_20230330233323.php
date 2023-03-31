@extends('layouts.mastersiswa')
    <div class="row">
        .
    </div>
                    @foreach($riwayat as $i => $rwt)

                        <tr>
                            <th colspan="2" class="text-uppercase text-secondary text-xl font-weight-bolder opacity-8">{{$rwt->tanggal}}</th>
                            <td>
                                <span class="badge {{renderStatusReservasi($rwt->status)}}">{{$rwt->status}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{$rwt->keterangan}}
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-8">{{$rwt->tanggal}}</th>
                            <td>

                            </td>
                        </tr>
                    @endforeach
@endsection