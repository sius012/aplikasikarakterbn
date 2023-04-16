@extends('layouts.master')
@push('css')
<style>
    .list-guru {
        list-style-type: none;
        position: absolute;
        width: 400px
    }

    .list-guru li a {
        display: block;
        font-weight: bold;
    }

    .list-guru-span{
        background-color: rgb(0, 255, 26)
    }

    .list-guru li {
        padding: 10px;
    }

    .photoprofile-text {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        background: red;
        color: white;
        height: 40px;
        width: 40px;
        border-radius: 50%;
    }

</style>
@endpush
@section('content')
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <h5 class="mr-3">Cari Penilai</h5>
                    <Label>Semua Guru</Label><input type="checkbox" id="semua_guru">
                    <div class="container">
                        <input type="text" class="form-control my-1" id="search-guru">
                        <ul class="list-guru card p-2"></ul>
                        <div class="row container-guru">

                        </div>
                    </div>


                </div>
                <div class="col-sm">

                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button class="btn btn-primary mt-3">Cek Raport Karakter</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function renderlist(img, data) {

    }
    $(document).ready(function() {
        $("#search-guru").keyup(function() {

            $.ajax({
                url: "{{route('eraport.getpenilailist')}}"
                , data: {
                    nama: $(this).val()
                }
                , type: "get"
                , dataType: 'json'
                , success: function(data) {
                    $(".list-guru").show();
                    let li = data.map(function(e) {

                        return `<li>
                            <div>
                                <a href="#" class='add-penilai' data-nama="${e['name']}" data-id="${e['id']}">
                                <div class='row'>
                                    <div class='col-2'>
                                        <div class='icon-guru text-center photoprofile-text'>
                                            ${renderDummyProfile(e['name'])}
                                        </div>
                                    </div>
                                    <div class='col-8'>
                                        ${e['name']}
                                    </div>
                                </div>
                            </a>
                            </div>
                            </li> `
                    })
                    $(".list-guru").html(li);
                }
            })
        })

        $(document).delegate(".add-penilai", 'click', function(e) {
            //alert('hole');

            $(".container-guru").append(`
            <div class="col list-guru-span">   
                                <input type='hidden' name='listguru[]' value='${$(this).data('id')}'>
                                <p>${$(this).data('nama')}</p>
                            </div>`);

            e.stopPropagation();
        })


        $(document).click(function() {
            $('.list-guru').toggle();
        })

        $(".list-guru").click(function(e) {

        })
    })

</script>
@endpush
