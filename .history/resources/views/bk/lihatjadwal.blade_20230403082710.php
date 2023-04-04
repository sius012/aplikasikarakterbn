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
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col"><img src="{{asset('images/profile.png')}}" alt="" style="height: 50px; width: 50px" class="rounded-circle"></div>
                                        <div class="col">
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <span class="m-3">{{$jk[$j]->bookedby->first()->pemesan->nama_siswa}}</span>
                                <div class="row">
                                    <div class="col mt-3 mr-5">
                                        <button class="btn btn-warning btn-edit-jadwal p-3 py-1"><i class="fa fa-edit"></i></button>
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

@endsection
@push("js")
<script>
    $(document).ready(function() {
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
        })
    })

</script>

@endpush
