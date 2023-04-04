@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <h4>{{$jadwalkonseling["jadwal_konseling"]->keterangan}}</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        @foreach($jadwalkonseling["detail"] as $i=> $jk)
                        <td>{{getDayName($i)}}</td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @for($j = 0;$j < 5;$j++) <tr class="field-input-jam">
                        @foreach($jadwalkonseling["detail"] as $k => $jk)
                        @if(isset($jk[$j]))
                        <td class="p-3 @if($jk[$j]->bookedby_count > 0) border-booked @endif" data-status="{{$jk[$j]->bookedby_count > 0 ? "booked" : "ready"}}" data-html="true" data-html="true">
                            @if($jk[$j]->bookedby_count > 0)
                            <div class="card card-info position-absolute">
                                <div class="card-body p-2">
                                    <div class="row">
                                        <div class="col-2"><img src="{{asset('images/profile.png')}}" alt="" style="height: 50px; width: 50px" class="rounded-circle"></div>
                                        <div class="col">
                                            <p class="m-3">{{$jk[$j]->bookedby->first()->pemesan->nama_siswa}}</p>
                                            <button class="btn btn-warning btn-edit-jadwal p-3 py-1" value="{{$jk[$j]->id_djk}}"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-success btn-reserv-jadwal p-3 py-1" value="{{$jk[$j]->id_djk}}"><i class="fa fa-check"></i></button>
                                            <button class="btn btn-danger btn-batal-jadwal p-3 py-1" value="{{$jk[$j]->id_djk}}"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col">
                                    Dari
                                    <input type="time" class="form-control  jam-field" placeholder="" value="{{$jk[$j]->dari}}" readonly></div>
                                <div class="col">
                                    Sampai
                                    <input type="time" class="form-control  jam-field" value="{{$jk[$j]->sampai}}" readonly></div>
                            </div>
                        </td>
                        @else
                        <td></td>
                        @endif
                        @endforeach
                        </tr>
                        @endfor
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <button class="btn btn-warning btn-edit"><i class="fa fa-edit"></i></button>
        </div>
    </div>
</div>

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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" id="modal-reserv">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Modal body text goes here.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@push("js")
<script>
    $(document).ready(function() {
        var selectedElement = null;
        var modalres = new bootstrap.Modal($("#modal-reschedule"));
        var modalreserv = new bootstrap.Modal($("#modal-reserv"));
       
        $(".btn-edit").click(function() {
            $(".jam-field").attr("readonly", function(index, attr) {
               if($(this).closest("td").data("status") == "ready"){
                return attr == "readonly" ? null : "readonly";
               }
               
            })
        })


        $("td[data-status=booked]").click(function(){
            var cardinfo = $(this).find(".card-info")

           
            cardinfo.toggle("fast")
        })

        $(".btn-edit-jadwal").click(function(e){
            e.stopPropagation();

            $.ajax({
                url: "{{route('bk.getdetailjadwal')}}",
                data: {
                    id: $(this).val()
                },
                type: "get",
                dataType: "json",
                success: function(data){
                    $("#hari-select").children("option").each(function(){
                       if($(this).attr("value") == data["hari"]){
                        $(this).attr("selected","selected")
                       }
                    })

                    $(".id-field").val(data["id_djk"])
                    $(".dari-field").val(data["dari"])
                    $(".sampai-field").val(data["sampai"])

                    modalres.show();
                },error: function(err){
                    alert(err.responseText);
                }
            })
        })


        $(".btn-reserv-jadwal").click(function(){
            
        })
    })

</script>

@endpush
