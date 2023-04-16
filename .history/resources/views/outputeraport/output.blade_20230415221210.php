<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Output</title>
</head>
<body>
    <table class="table-custom">
        <thead>
            <tr>
                @foreach($siswa as $s => $sws)
                <td colspan="7">RAPOR KARAKTER SISWA TAHUN PELAJARAN 2022/2023
                </td>
                @endforeach
            </tr>
            <tr>
                @foreach($siswa as $s => $sws)
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                @endforeach
            </tr>
            <tr>
                @foreach($siswa as $s => $sws)
                <td>Nama Siswa</td>
                <td>:</td>
                <td>{{$sws->nama_siswa}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                @endforeach
            </tr>
            <tr>
                @foreach($siswa as $s => $sws)
                <td>Kelas dan Jurusan</td>
                <td>:</td>
                <td>{{$kelas}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                @endforeach
            </tr>
            <tr>
                @foreach($siswa as $s => $sws)
                <td>Semester</td>
                <td>:</td>
                <td>Ganjil</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                @endforeach
            </tr>
            <tr>
                @foreach($siswa as $s => $sws)
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                @endforeach
            </tr>
            <tr>
                @foreach($siswa as $s => $sws)
                <td colspan="2"  style="background: #92D050">No</td>
                <td style="background: #92D050">Faktor Penilaian Karakter</td>
                <td  style="background: #92D050">Belum Berkembang</td>
                <td  style="background: #92D050">Mulai Berkembang</td>
                <td  style="background: #92D050">Sudah Berkembang</td>
                <td  style="background: #92D050">Membudaya</td>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
            $c_subpoint = "";
            $c_point = "";
            @endphp
            @foreach($rekaplist as $j => $rl)
            @php
            list($aspek, $subpoint, $point) = explode(":",$j);
            @endphp
            @if($rl["point"] != $c_point)
            <tr>
                @foreach($rl["siswa"] as $s => $sws)
                <td colspan="2">{{$point}}</td>
                <td colspan="5">{{$rl["point"]}}</td>
                @endforeach
            </tr>
            @php
            $c_point = $rl["point"];
            @endphp
            @endif

            @if($rl["subpoint"] != $c_subpoint)
            <tr>
                @foreach($rl["siswa"] as $s => $sws)
                <td colspan="2" style="background: #C4D79B">{{$subpoint}}</td>
                <td>{{$rl["subpoint"]}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                @endforeach
            </tr>
            @php
            $c_subpoint = $rl["subpoint"];
            @endphp
            @endif

            <tr>

                @foreach($rl["siswa"] as $s => $sws)
                <td colspan="2">{{$aspek}}</td>
                <td>{{$rl["aspek"]}}</td>
                <td>@if(hurufDari($sws["nilai_sekolah"]['jumlah_akumulatif'])["huruf"] == "D") √@endif </td>
                <td>@if(hurufDari($sws["nilai_sekolah"]['jumlah_akumulatif'])["huruf"] == "C") √@endif</td>
                <td>@if(hurufDari($sws["nilai_sekolah"]['jumlah_akumulatif'])["huruf"] == "B") √@endif</td>
                <td>@if(hurufDari($sws["nilai_sekolah"]['jumlah_akumulatif'])["huruf"] == "A") √@endif</td>
                @endforeach
            </tr>



            @endforeach
        </tbody>
    </table>
</body>
</html>
          
    