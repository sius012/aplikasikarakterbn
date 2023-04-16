<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@if(count($siswa) > 1) Output @else Siswa  @endif</title>
</head>
<body>
    <table class="table-custom">
        <thead>
            <tr>
                @foreach($siswa as $s => $sws)
                <td colspan="7" style="font-weight: bold;" align="center" valign="center">RAPOR KARAKTER SISWA TAHUN PELAJARAN 2022/2023
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
                <td style="font-weight: bold;">Nama Siswa</td>
                <td style="font-weight: bold;">:</td>
                <td style="font-weight: bold">{{$sws->nama_siswa}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                @endforeach
            </tr>
            <tr>
                @foreach($siswa as $s => $sws)
                <td style="font-weight: bold">Kelas/Jurusan</td>
                <td style="font-weight: bold">:</td>
                <td style="font-weight: bold">{{$kelas}}/{{$jurusan}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                @endforeach
            </tr>
            <tr>
                @foreach($siswa as $s => $sws)
                <td style="font-weight: bold">Semester</td>
                <td style="font-weight: bold">:</td>
                <td style="font-weight: bold">Ganjil</td>
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
                <td colspan="2"  style="background: #92D050;border: 2px solid black">No</td>
                <td style="background: #92D050;font-weight: bold;border: 2px solid black">Faktor Penilaian Karakter</td>
                <td  style="background: #92D050;font-weight: bold;border: 2px solid black">Belum Berkembang</td>
                <td  style="background: #92D050;font-weight: bold;border: 2px solid black">Mulai Berkembang</td>
                <td  style="background: #92D050;font-weight: bold;border: 2px solid black">Sudah Berkembang</td>
                <td  style="background: #92D050;font-weight: bold;border: 2px solid black">Membudaya</td>
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
                <td colspan="2" valign="center" align="center" style="font-weight: bold; background:#FFC000;border: 2px solid black" >{{$point}}</td>
                <td colspan="5" valign="center" style="font-weight: bold;background: #FFC000;border: 2px solid black">{{$rl["point"]}}</td>
                @endforeach
            </tr>
            @php
            $c_point = $rl["point"];
            @endphp
            @endif

            @if($rl["subpoint"] != $c_subpoint)
            <tr>
                @foreach($rl["siswa"] as $s => $sws)
                <td colspan="2"  valign="center"align="center" style="background: #C4D79B;border: 2px solid black">{{$subpoint}}</td>
                <td  valign="center"style="background: #C4D79B;border: 2px solid black">{{$rl["subpoint"]}}</td>
                <td style="background: #C4D79B;border: 2px solid black"></td>
                <td style="background: #C4D79B;border: 2px solid black"></td>
                <td style="background: #C4D79B;border: 2px solid black"></td>
                <td style="background: #C4D79B;border: 2px solid black"></td>
                @endforeach
            </tr>
            @php
            $c_subpoint = $rl["subpoint"];
            @endphp
            @endif

            <tr>

                @foreach($rl["siswa"] as $s => $sws)
                <td colspan="2" a>{{$aspek}}</td>
                <td  valign="center" style="border: 2px solid black;border: 2px solid black">{{$rl["aspek"]}}</td>
                <td style="background: #B8CCE4;border: 2px solid black">@if(hurufDari($sws["nilai_sekolah"]['jumlah_akumulatif'])["huruf"] == "D") √@endif </td>
                <td style="background: #B8CCE4;border: 2px solid black">@if(hurufDari($sws["nilai_sekolah"]['jumlah_akumulatif'])["huruf"] == "C") √@endif</td>
                <td style="background: #B8CCE4;border: 2px solid black">@if(hurufDari($sws["nilai_sekolah"]['jumlah_akumulatif'])["huruf"] == "B") √@endif</td>
                <td style="background: #B8CCE4;border: 2px solid black">@if(hurufDari($sws["nilai_sekolah"]['jumlah_akumulatif'])["huruf"] == "A") √@endif</td>
                @endforeach
            </tr>



            @endforeach
            <tr>
                @foreach($siswa as $s => $sks)
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
                @foreach($siswa as $s => $sks)
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
                @foreach($siswa as $s => $sks)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Semarang {{date('d M Y')}}</td>
                    <td></td>
                    <td></td>
                @endforeach
            </tr>
            <tr>
                @foreach($siswa as $s => $sks)
                    <td></td>
                    <td></td>
                    <td>Kepala Wisma Remaja Bagimu Negeriku</td>
                    <td></td>
                    <td>Wali Kelas</td>
                    <td></td>
                    <td></td>
                @endforeach
            </tr>
            <tr>
                @foreach($siswa as $s => $sks)
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
                @foreach($siswa as $s => $sks)
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
                @foreach($siswa as $s => $sks)
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
                @foreach($siswa as $s => $sks)
                    <td></td>
                    <td></td>
                    <td>.....................</td>
                    <td></td>
                    <td>Dionisius Setya Hermawan</td>
                    <td></td>
                    <td></td>
                @endforeach
            </tr>
            <tr>
                @foreach($siswa as $s => $sks)
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
                @foreach($siswa as $s => $sks)
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
                @foreach($siswa as $s => $sks)
                    <td colspan="7">Mengetahui</td>
                @endforeach
            </tr>
            <tr>
                @foreach($siswa as $s => $sks)
                    <td colspan="7">Kepala SMK Bagimu Negeriku Semarang</td>
                @endforeach
            </tr>
            <tr>
                @foreach($siswa as $s => $sks)
                    <td colspan="7"></td>
                @endforeach
            </tr>
            <tr>
                @foreach($siswa as $s => $sks)
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
                @foreach($siswa as $s => $sks)
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
                @foreach($siswa as $s => $sks)
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
                @foreach($siswa as $s => $sks)
                    <td></td>
                    <td></td>
                    <td>Drs. Christianus Dwi Estafianto</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endforeach
            </tr>
            <tr>
                @foreach($siswa as $s => $sks)
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
                @foreach($siswa as $s => $sks)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="2">{{$sks->nama_siswa}}</td>
                @endforeach
            </tr>

        </tbody>
    </table>
</body>
</html>
          
    