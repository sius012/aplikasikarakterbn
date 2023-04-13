@extends('layouts.master')
@section('branch1', 'Guru BK')
@section('branch2', 'Jadwal Saya')
@section('title', 'Jadwal Saya')

@section('content')


<div class="containesr" style="height: 1000px">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h5>Jadwal Konseling</h5>
                </div>
                <div class="col text-end">
                    <button class="btn bg-gradient-primary" data-bs-target="#modal-tambah" data-bs-toggle="modal">Buat Jadwal</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col"><input type="date" name="dari" class="form-control"></div>
                            <div class="col"><input type="date" name="sampai" class="form-control"></div>
                            <div class="col"><button type="submit" class="btn btn-primary">Cari</button></div>
                        </div>
                    </div>
                </div>
            </form>
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
                        $rentang = rentangtanggal($jk['data']->minggu, $jk['data']->bulan);
                        @endphp
                        <tr>
                            <td>{{$rentang["dari"]}} - {{$rentang["sampai"]}}</td>
                            <td>{{$jk['data']->keterangan}}</td>
                            <td><a href="{{route('profil.lihatjadwal', ['id'=>$jk['data']->id_jk])}}"><button class="btn bg-gradient-info px-3 py-2"><i class="fa fa-info"></i></button></a>
                                @if($jk["booked"] == false) <a href=""><button class="btn bg-gradient-danger px-3 py-2 btn-hapus-jadwal" value="{{$jk['data']->id_jk}}"><i class="fa fa-trash "></i></button></a> @endif
                            </td>
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
                            <label for="" class="form-label">Pilih Bulan</label>
                            <select name="bulan" id="" class="form-select" required>
                                @php
                                $bulans = ["Januari",'Februari',"Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
                                @endphp
                                @for($bulan = 1; $bulan <= 12; $bulan++) 
                                <option value="{{$bulan}}" @if($bulan == \Carbon\Carbon::now()->month) selected @endif>{{$bulans[$bulan-1]}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Pilih Minggu</label>
                            <select name="minggu" id="" class="form-select" required>
                                <option value="1" @if(1 == <div class="card text-left">
                                  <img class="card-img-top" src="holder.js/100px180/" alt="">
                                  <div class="card-body">
                                    <h4 class="card-title">Title</h4>
                                    <p class="card-text">Body</p>
                                  </div>
                                </div>)>Minggu Pertama</option>
                                <option value="2">Minggu Kedua</option>
                                <option value="3">Minggu Ketiga</option>
                                <option value="4">Minggu Keempat</option>
                                <option value="5">Minggu Kelima</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" required name="keterangan">
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
            var len = $(this).closest("table").find('tbody').children('tr').length;
            if (len < 4) {
                var table = $(this).closest("table")
                var nomer = $(this).closest(".table-responsive").find(".no-jadwal");
                let no = parseInt(nomer.val())
                var cont = table.find(".container-jadwal").append(`
          <tr>
            <td class='nomer'>${nomer.val()}</td>  
            <td>
                <input type='time' class='form-control input-date-dari' name='jadwal[${table.data("day")}][][dari]' required>
            </td>
            <td><input type='time' class='form-control input-date-sampai' min='08:00' name='jadwal[${table.data("day")}][][sampai]' required></td>
            <td><button class='btn btn-delete-row btn-danger'><i class='fa fa-trash'></i></button></td>
          </tr>
          `)

                table.children("tbody").children("tr").each(function(i) {
                    $(this).children(".nomer").text(i + 1)
                    $(this).find(".input-date-dari").attr('name', `jadwal[${table.data("day")}][${i}][dari]`);
                    $(this).find(".input-date-sampai").attr('name', `jadwal[${table.data("day")}][${i}][sampai]`);
                })
            }

        })


        $(document).delegate(".btn-danger", "click", function() {

            var table = $(this).closest("table");

            $(this).closest("tr").remove();
            table.children("tbody").children("tr").each(function(i) {
                $(this).children(".nomer").text(i + 1)
                $(this).find(".input-date-dari").attr('name', `jadwal[${table.data("day")}][${i}][dari]`);
                $(this).find(".input-date-sampai").attr('name', `jadwal[${table.data("day")}][${i}][sampai]`);
            })
        })

        $(document).delegate(".input-date-dari", "change", function() {
            var table = $(this).closest("table");
            table.find("input").each(function() {});
        })

        $(".btn-hapus-jadwal").click(function(e) {

            e.preventDefault()
            Swal.fire({
                title: 'Apakah Anda yakin ingin menghapus?'
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonText: 'OK'
                , cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kode yang akan dijalankan jika tombol "OK" ditekan
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr('content')
                        }
                        , data: {
                            id: $(this).val()
                        }
                        , url: "{{route('bk.hapusjadwal')}}"
                        , type: "post"
                        , success: function() {
                            alert('tes')
                            window.location = "";
                        }
                        , error: function(err) {
                            alert(err.responseText)
                        }
                    })
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Kode yang akan dijalankan jika tombol "Batal" ditekan
                    console.log('Anda telah menekan tombol Batal.');
                }
            });

        })
    })

</script>
@endpush
