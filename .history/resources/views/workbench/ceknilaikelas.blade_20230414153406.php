@extends('layouts.master')
@push('css')
<style>
    .list-guru{
        position: absolute
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
                    <input type="text" class="form-control my-1" id="search-guru">
                    <ul class="list-guru"></ul>
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
    $(document).ready(function() {
        $("#search-guru").keyup(function() {
            $.ajax({
                url: "{{route('eraport.getpenilailist')}}"
                , data: {
                    nama: $(this).val()
                },
                type: "get",
                dataType: 'json',
                success: function(data){
                    let li = data.map(function(e){
                        return `<li>${e['name']}</li> `
                    })
                    $(".list-guru").html(li);
                }
            })
        })
    })

</script>
@endpush
