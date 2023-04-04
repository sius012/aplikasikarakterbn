<div class="card mt-3">
    <div class="card-header">
        <h6>Output Eraport Kelas {{$kelas}} {{$jurusan}}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
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
                        <td>XII RPL</td>
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
                        <td></td>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($siswa as $s => $sws)
                        <td colspan="2">No</td>
                        <td>Faktor Penilaian Karakter</td>
                        <td>Belum Berkembang</td>
                        <td>Mulai Berkembang</td>
                        <td>Sudah Berkembang</td>
                        <td>Membudaya</td>
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
                        <td colspan="2">{{$point}}</td>
                        <td>{{$rl["point"]}}</td>
                    </tr>
                    @php
                    $c_point = $rl["point"];
                    @endphp
                    @endif

                    @if($rl["subpoint"] != $c_subpoint)
                    <tr>
                        <td colspan="2">{{$subpoint}}</td>
                        <td>{{$rl["subpoint"]}}</td>
                        @foreach($rl["siswa"] as $s => $sws)
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
                        <td colspan="2">{{$aspek}}</td>
                        <td>{{$rl["aspek"]}}</td>
                        @foreach($rl["siswa"] as $s => $sws)
                        <td>@if(hurufDari($sws["nilai_sekolah"]['jumlah_akumulatif'])["huruf"] == "A")  <i class="fa fa-check"></i>@endif </td>
                        <td>@if(hurufDari($sws["nilai_sekolah"]['jumlah_akumulatif'])["huruf"] == "B")  <i class="fa fa-check"></i>@endif</td>
                        <td>@if(hurufDari($sws["nilai_sekolah"]['jumlah_akumulatif'])["huruf"] == "C")  <i class="fa fa-check"></i>@endif</td>
                        <td>@if(hurufDari($sws["nilai_sekolah"]['jumlah_akumulatif'])["huruf"] == "D")  <i class="fa fa-check"></i>@endif</td>
                        @endforeach
                    </tr>



                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
