@extends('layouts.master')

@section('content')


<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h5>Jadwal Konseling</h5>
                </div>
                <div class="col">
                    <button class="btn bg-gradient-primary" data-bs-target="#modal-tambah" data-bs-toggle="modal">Buat Jadwal</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Minggu</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwalkonseling as $i =>$jk)
                        @php 
                            $rentang = rentangtanggal($jk->minggu, $jk->bulan);
                        @endphp
                        <tr>
                            <td>{{$rentang["dari"]}} - {{$rentang["sampai"]}}</td>
                            <td>{{$jk->keterangan}}</td>
                            <td><a href="{{route('profil.lihatjadwal', ['id'=>$jk->id_jk])}}"><button class="btn bg-gradient-info px-3 py-2"><i class="fa fa-info"></i></button></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="modal-tambah" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{route('profil.storejadwal')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" required name="keterangan">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Pilih Bulan</label>
                            <select name="bulan" id="" class="form-select" required>
                                @php
                                $bulans = ["Januari",'Februari',"Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
                                @endphp
                                @for($bulan = 1; $bulan <= 12; $bulan++) <option value="{{$bulan}}">{{$bulans[$bulan-1]}}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Pilih Minggu</label>
                            <select name="minggu" id="" class="form-select" required>
                                <option value="1">Minggu Pertama</option>
                                <option value="2">Minggu Kedua</option>
                                <option value="3">Minggu Ketiga</option>
                                <option value="4">Minggu Keempat</option>
                                <option value="5">Minggu Kelima</option>
                            </select>
                        </div>
                        <div class="container-fluid">
                            @foreach($hari as $day)
                            <div class="table-responsive">
                                <input type="hidden" value="1" class="no-jadwal">
                                <table class="table table-bordered" data-day="{{$day['lc']}}">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Hari {{$day["label"]}}</th>
                                            <th class="align-le"><button type="button" class="btn btn-sm btn-primary m-0 btn-jadwal">+</button></th>
                                        </tr>
                                        <tr>
                                            <th>Jam ke</th>
                                            <th>Dari</th>
                                            <th>Sampai</th>
                                            <th style="width: 10px"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="container-jadwal">
                                    </tbody>
                                </table>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>


            </form>

        </div>
    </div>
</div>


@endsection

@push("js")
<script>
    $(document).ready(function() {
        var modalres = $("#modal-reschedule");
        $(".btn-jadwal").click(function() {
            var table = $(this).closest("table")
            var nomer = $(this).closest(".table-responsive").find(".no-jadwal");
            let no = parseInt(nomer.val())
            var cont = table.find(".container-jadwal").append(`
          <tr>
            <td>${nomer.val()}</td>  
            <td>
                <input type='time' class='form-control input-date-dari' name='jadwal[${table.data("day")}][${no}][dari]' required>
            </td>
            <td><input type='time' class='form-control input-date-sampai' name='jadwal[${table.data("day")}][${no}][sampai]' required></td>
            <td><button class='btn btn-delete-row btn-danger'><i class='fa fa-trash'></i></button></td>
          </tr>
          `)
            nomer.val(parseInt(nomer.val()) + 1);
        })


        $(document).delegate(".btn-danger", "click", function(){
            $(this).closest("tr").remove();
        })

        $(document).delegate(".input-date-dari","change",function(){
            var table = $(this).closest("table");
            table.children("")
        })
    })

</script>
@endpush
