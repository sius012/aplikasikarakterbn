@extends('layouts.master')
@section('title', 'Hak Akses '.$user->name)
@push("css")
<style>
    .list-data {
        list-style-type: none;
        position: absolute;
        width: 400px
    }

    .list-data li a {
        display: block;
        font-weight: bold;
    }

</style>
@endpush
@section('content')
<button class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#modal-hak-akses">
    Tambah Hak Akses
</button>
<div class="card mb-4">
    <div class="card-header pb-0">
        <h6>Authors table</h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-uppercase text-secondary text-xxs font-weight-bolder">Sebagai</th>
                        <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder ">Kelas</th>
                        <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder ps-2">Jurusan</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Dari</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sampai</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hakakses as $i => $ha)
                    <tr>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <p class="text-xs font-weight-bold mb-0">{{$ha->sebagai}}</p>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs text-center text-secondary mb-0">{{$ha->}}</p>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <p class="text-xs text-center text-secondary mb-0">{{$ha->jurusan->jurusan}}</p>
                        </td>
                        <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">{{Carbon\Carbon::parse($ha->dari)->toDateString()}}</span>
                        </td>
                        <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">{{Carbon\Carbon::parse($ha->sampai)->toDateString()}}</span>
                        </td>
                        <td class="align-middle text-center">
                            <span class=" text-xs font-weight-bold badge @if($ha->status == 'await') bg-gradient-primary @else bg-gradiet-info @endif">{{$ha->status}}</span>
                        </td>
                        <td class="align-middle text-center">
                            <div class="btn-group">
                                <form action="{{route('hakaksessaya.destroy', ['hakaksessaya'=>$ha->id])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn bg-gradient-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                @if($ha->status == "await")
                                <form action="{{route('hakaksessaya.update',['hakaksessaya'=>$ha->id])}}" method="POST">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn bg-gradient-success">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </form>
                                @endif
                            </div>

                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-hak-akses" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Tambah Hak Akses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route("admin.konfigurasiumum.pengguna.hak.tambah")}}" method="POST">
                @csrf
                <input type="hidden" value="{{$id}}" name="id_user">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Sebagai</label>
                        <input type="text" class="form-control" name="sebagai">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Angkatan</label>
                        <input type="checkbox">
                        <div class="input-parent">
                            <input type="text" class="form-control search-aj " data-type="angkatan">
                            <ul class="list-group " style="width: 100px" id="angkatan">
    
                            </ul>
                            <div class="child-input d-flex">

                            </div>
                        </div>

                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Jurusan</label>
                            <div class='input-parent'>
                                <input type="text" class="form-control search-aj" data-type="jurusan">
                                <ul class="list-group position-absolute" style="width: 100px" id="jurusan">
                                </ul>
                                <div class="child-input d-flex">
                              </div>
                            </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Agama</label>
                        <div class='input-parent'>
                            <input type="text" class="form-control search-aj" data-type="agama">
                            <ul class="list-group position-absolute" style="width: 100px" id="agama">
                            </ul>
                            <div class="child-input d-flex">
                            
                        </div>
                    </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label">
                            Dari
                        </label>
                        <input type="date" class="form-control" name="dari">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label">
                            Sampai
                        </label>
                        <input type="date" class="form-control" name="sampai">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" type="submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push("js")
<script>
    $(document).ready(function() {
        $(document).click(function(e){
          $(".list-group").hide();
        })

        $(".input-parent").click(function(e){
         //  e.stopPropagation();
        })
        $(".search-aj").keyup(function() {
            var params = $(this).data("type")
            var el = $(this).parent().find(".list-group");
           
            $(".list-group").show();
            $.ajax({
                url: "{{route('getaj')}}"
                , type: "get"
                , data: {
                    params: params
                    , key: $(this).val()
                }
                , dataType: "json"
                , success: function(data) {
                    console.log(data);
                    var element = $("#angkatan")
                    let list = "";
                    
                    switch (params) {
                        case "angkatan":
                            list = data.map(function(e) {
                                return ` <li class="list-group-item"><a href="#" class="add-item" data-type="angkatan" data-val="${e["id_angkatan"]}" data-label="${e["id_angkatan"]}">${e['id_angkatan']}</a> </li>`
                            })
                            break;
                         case "jurusan":
                            list = data.map(function(e) {
                                return ` <li class="list-group-item"><a href="#" class="add-item" data-type="jurusan" data-val="${e["id_jurusan"]}" data-label="${e['jurusan']}">${e['jurusan']}</a> </li>`
                            })
                            break;

                         case "agama":
                            list = data.map(function(e,i) {
                                return ` <li class="list-group-item"><a href="#" class="add-item" data-type="agama" data-val="${e}" data-label="${e}">${e}</a> </li>`
                            })
                        default:
                            break;
                    }
                    el.html(list)
                }
                , error: function(err) {
                    //alert(err.responseText)
                }
            })
        })


        $(document).delegate(".add-item", "click",function(){
          var type = $(this).data("type");
          var val = $(this).data("val");
           var element = $(this).closest(".input-parent");
           var childinput = element.find(".child-input");
           let count = 0;
           childinput.children(".input-cont").each(function(e){
                if($(this).find("input").val() == val ){
                    count++;
                }
           })


           if(count<1){
            childinput.append(`
                                <div class="input-cont m-2">
                                    <span class="badge bg-danger x">${$(this).data('label')} <a href="#" class="text-white remove-item">X</a></span>
                                    <input type="hidden" name="${type}[]" value="${val}">
                                </div>
           `)
           }
          
        })
    })

</script>
@endpush
@endsection
