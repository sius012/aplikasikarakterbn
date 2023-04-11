@extends('layouts.master')
@section("title","Lihat Jadwal")
@section('branch1', 'Guru BK')
@section('branch2', 'Lihat Jadwal')
@section('content')
<form action="{{route('bk.updatejadwal')}}" method="POST">
    @method('put')
    @csrf
    <div class="card">
        <div class="card-header">
            <h4>{{$jadwalkonseling["jadwal_konseling"]->keterangan}}</h4>
        </div>
        <div class="card-body">
            <div class="container mb-5">
                <input type="hidden" value="{{$jadwalkonseling["jadwal_konseling"]->id_jk}}" name="id_jk" required>
                <div class="row">
                    <div class="col">
                        <label for="" class="form-label">
                            Keterangan
                        </label>
                        <input type="text" name="keterangan" class="form-control" value="{{$jadwalkonseling["jadwal_konseling"]->keterangan}}">
                    </div>
                    <div class="col">
                        <label for="" class="form-label">
                            Bulan
                        </label>
                        <select name="bulan" id="" class="form-control">
                            @foreach(bulans() as $i => $bln)
                            <option value="{{$i+1}}" @if($i+1==$jadwalkonseling["jadwal_konseling"]->bulan) selected @endif>{{$bln}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="" class="form-label">
                            Minggu Ke
                        </label>
                        <input type="number" name="minggu" class="form-control" value="{{$jadwalkonseling["jadwal_konseling"]->minggu}}">
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Siswa</p>
                                            <h5 class="font-weight-bolder mb-0">
                                                5 Orang
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                            <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Menunggu</p>
                                            <h5 class="font-weight-bolder mb-0">
                                                2 Sesi
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div class="icon icon-shape bg-gradient-secondary shadow text-center border-radius-md">
                                            <i class="fa fa-spinner opacity-10" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Reschedule</p>
                                            <h5 class="font-weight-bolder mb-0">
                                                2 Sesi
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                            <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Selesai</p>
                                            <h5 class="font-weight-bolder mb-0">
                                                5 Sesi
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                            <i class="fa fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="table-responsive">
                <div class="container">
                    <div class="row">
                        @foreach($jadwalkonseling["detail"] as $i=> $jk)
                        <div class="col-sm p-4 fw-bolder">{{getDayName($i)}}</div>
                        @endforeach
                    </div>
                    @for($j = 0;$j < 5;$j++) <div class="row">
                        @foreach($jadwalkonseling["detail"] as $k => $jk)
                        @if(isset($jk[$j]))
                        <div class="col-sm" @if($jk[$j]->bookedby_count > 0) data-status="booked" @endif>
                            <div class="session-card @if($jk[$j]->bookedby_count > 0) @if($jk[$j]->bookedby->first()->status="Selesai") done @elseif($jk[$j]->bookedby->first()->status="Dipesan") booked @else reschedule @endif @endif">
                                @if($jk[$j]->bookedby_count > 0)
                                <div class="card card-info mb-3 position-absolute" style="max-width: 400px;">
                                    <div class="row g-0">
                                        <div class="col-md-3">
                                            <img src="{{$jk[$j]->bookedby->first()->pemesan->getimageurl()}}" class="img-fluid rounded-start" alt="...">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body p-2">
                                                <h5 class="card-title">{{$jk[$j]->bookedby->first()->pemesan->nama_siswa}}</h5>
                                                <p class="card-text">{{$jk[$j]->bookedby->first()->keterangan_siswa}}</p>
                                                <div class="container">
                                                    @if($jk[$j]->bookedby->first()->status !="Selesai")
                                                    <button type="button" class="btn btn-warning m-0 btn-edit-jadwal p-3 py-1" value="{{$jk[$j]->id_djk}}"><i class="fa fa-edit"></i></button>
                                                    <button type="button" class="btn btn-success m-0 btn-reserv-jadwal p-3 py-1" value="{{$jk[$j]->id_djk}}" data-idb="{{$jk[$j]->bookedby->first()->id_bk}}"><i class="fa fa-check"></i></button>
                                                    <button type="button" class="btn btn-danger m-0 btn-batal-jadwal p-3 py-1" value="{{$jk[$j]->id_djk}}"><i class="fa fa-trash"></i></button>
                                                    @else
                                                    <button type="button" class="btn btn-info m-0 btn-info-sesi p-3 py-1" value="{{$jk[$j]->id_djk}}"><i class="fa fa-info"></i></button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    <input type="hidden" value="{{$jk[$j]->hari}}" name="djk[{{$jk[$j]->id_djk}}][hari]">
                                    <div class="col">
                                        Dari
                                        <input type="time" @if($jk[$j]->bookedby_count < 1) name="djk[{{$jk[$j]->id_djk}}][dari]" @endif class="form-control  jam-field" placeholder="" value="{{$jk[$j]->dari}}" readonly>
                                    </div>
                                    <div class="col">
                                        Sampai
                                        <input type="time" @if($jk[$j]->bookedby_count < 1)name="djk[{{$jk[$j]->id_djk}}][sampai]" @endif class="form-control  jam-field" value="{{$jk[$j]->sampai}}" readonly>
                                    </div>
                                </div>
                            </div>
                           

                        </div>
                        @else
                        <div class="col-sm">

                        </div>
                        @endif
                        @endforeach
                </div>
                @endfor
            </div>
        </div>
       

        <div class="card-footer">
            <button type="button" class="btn btn-warning btn-edit"><i class="fa fa-edit"></i></button>
            <button type="submit" class="btn btn-warning btn-update"><i class="fa fa-send"></i>Perbarui</button>
        </div>
    </div>
    </div>
</form>

<div class="modal fade" id="modal-reschedule" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Atur Ulang Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('bk.editdetailjadwal')}}" method="POST">
                @method('put')
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="" class="form-label">
                            Atur Ulang Hari
                        </label>
                        <input type="hidden" value="" class="id-field" name="id_djk">
                        <select name="hari" id="hari-select" class="form-control">
                            <option value="1">Senin</option>
                            <option value="2">Selasa</option>
                            <option value="3">Rabu</option>
                            <option value="4">Kamis</option>
                            <option value="5">Jumat</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Atur Ulang Jam</label>
                        <div class="row">
                            <div class="col"><label for="" class="form-label">Dari</label></div>
                            <div class="col"><label for="" class="form-label">Sampai</label></div>
                        </div>
                        <div class="row">
                            <div class="col"><input type="time" class="form-control dari-field" name="dari"></div>
                            <div class="col"><input type="time" class="form-control sampai-field" name="sampai"></div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Keterangan</label>
                        <input type="text" name="keterangan_reschedule" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-info-sesi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Info Konseling</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="" class="form-label">
                Tanggal
            </label>
            <input type="date" class="form-control">
          </div>
          <div class="form-group">
            <label for="" class="form-label">
                Konseli
            </label>
            <input type="date" class="form-control">
          </div>
          <div class="form-group">
            <label for="" class="form-label">
                Konselor
            </label>
            <input type="date" class="form-control">
          </div>
          <div class="form-group">
            <label for="" class="form-label">
                Tempat
            </label>
            <input type="date" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Understood</button>
        </div>
      </div>
    </div>
  </div>


<div class="modal fade" tabindex="-1" id="modal-reserv">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Akhiri Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('bk.selesaireservasi')}}" method="POST">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <input type="hidden" class="id-bk" name="id_bk" required>
                    <div class="form-group">
                        <label for="
                " class="form-label">Tempat Konseling</label>
                        <input type="text" class="form-control" name="tempat" required>
                    </div>
                    <div class="form-group">
                        <label for="
                " class="form-label">Pendekatan Yang Digunakan</label>
                        <input type="text" class="form-control" name="pdg" required>
                    </div>
                    <div class="form-group">
                        <label for="
                " class="form-label">Proses Konseling</label>
                        <input type="text" class="form-control" name="keterangan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Selesai</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push("js")
<script>
    $(document).ready(function() {
        $(".btn-update").hide();
        var selectedElement = null;
        var modalres = new bootstrap.Modal($("#modal-reschedule"));
        var modalreserv = new bootstrap.Modal($("#modal-reserv"));
        var modalinfosesi = new bootstrap.Modal($("#modal-info-sesi"));

        $(".btn-edit").click(function() {
            $(".btn-update").toggle();
            $(".jam-field").attr("readonly", function(index, attr) {
                if ($(this).closest("td").data("status") == "ready") {
                    return attr == "readonly" ? null : "readonly";
                }

            })
        })

        $(".btn-info-sesi").click(function(){
            modalinfosesi.show()
        })

        $("div[data-status=booked]").click(function() {
            var cardinfo = $(this).find(".card-info")
            cardinfo.toggle("fast")
        })

        $(".btn-edit-jadwal").click(function(e) {
            e.stopPropagation();

            $.ajax({
                url: "{{route('bk.getdetailjadwal')}}"
                , data: {
                    id: $(this).val()
                }
                , type: "get"
                , dataType: "json"
                , success: function(data) {
                    $("#hari-select").children("option").each(function() {
                        if ($(this).attr("value") == data["hari"]) {
                            $(this).attr("selected", "selected")
                        }
                    })

                    $(".id-field").val(data["id_djk"])
                    $(".dari-field").val(data["dari"])
                    $(".sampai-field").val(data["sampai"])

                    modalres.show();
                }
                , error: function(err) {
                    alert(err.responseText);
                }
            })
        })


        $(".btn-reserv-jadwal").click(function(e) {
            e.stopPropagation();
            $(".id-bk").val($(this).data('idb'));
            modalreserv.show();

        })
    })

</script>

@endpush
