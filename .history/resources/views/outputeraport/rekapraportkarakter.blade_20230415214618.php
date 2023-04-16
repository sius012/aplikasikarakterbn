<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap</title>    
</head>

<body>
    <table class="m-3">
        <tr>
            <td align="center" valign="center" rowspan="3" colspan="5" style="font-weight: bold">Akumulasi nilai Karakter</td>
        </tr>
        <tr>
            <td  style="font-weight: bold"></td>
        </tr>
        <tr>
            <td  style="font-weight: bold"></td>
        </tr>
        <tr>
            <td align="center" valign="center" rowspan="3" style="background: #C4D79B">No</td>
            <td align="center" valign="center" rowspan="3" style="width: 400px;background: #C4D79B"><b>Faktor Penilaian Karakter</b></td>
            @foreach($siswa as $i => $siswas)
            <td colspan=2 align="center" valign="center" style="background: #B1A0C7">{{$siswas->nama_siswa}}</td>
            @endforeach
        </tr>
        <tr>
            @foreach($siswa as $i => $siswas)
            <td align="center" valign="cemter" colspan="2" style="background: #B1A0C7">{{$siswas->no_absen}}</td>
            @endforeach
        </tr>
        <tr>
            @foreach($siswa as $i => $siswas)
            <td align="center" valign="center">Nilai Akhir</td>
            <td align="center" valign="center" style="background: #E6B8B7">Nilai Huruf</td>
            @endforeach

        </tr>
        <tbody>
            @php

            $no_aspek = "";
            $no_subpoint = "";
            $no_point = "";
            @endphp
            @foreach($rekaplist as $j => $lsr)
            @php

            list($no,$subpoint,$point) = explode(":",$j);
            @endphp
            @if($no_point != $point)
            <tr>
                <td align="center" valign="center" style="background: #FFC000">{{$point}}</td>
                <td align="center" valign="center" style="background: #FFC000">{{$lsr['point']}}</td>
                @foreach($siswa as $s => $sws)
                <td style="background: #FFC000"></td>
                <td style="background: #FFC000"></td>
                @endforeach
            </tr>
            @php
            $no_point = $point;
            @endphp
            @endif
            @if($no_subpoint != $subpoint)
            <tr  >
                <td align="center" valign="center" style="background: #C4D79B">{{$subpoint}}</td>
                <td align="center" valign="center" style="background: #C4D79B">{{$lsr["subpoint"]}}</td>
                @foreach($siswa as $s => $sws)
                <td style="background: #C4D79B"></td>
                <td style="background: #C4D79B"></td>
                @endforeach
            </tr>
            @php
            $no_subpoint = $subpoint;
            @endphp
            @endif
            <tr>
                <td>{{$no}}</td>
                <td>{{$lsr['aspek']}}</td>
                @foreach($lsr["siswa"] as $key => $sis)
                <td class="has-tooltips" data-header="Jumlah Penilai" data-jumlah="{{$sis['nilai_sekolah']['jumlah'] }}">{{$sis["nilai_sekolah"]["jumlah_akumulatif"]}}</td>
                <td style="background: #E6B8B7">{{hurufDari($sis["nilai_sekolah"]["jumlah_akumulatif"])["huruf"]}}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>