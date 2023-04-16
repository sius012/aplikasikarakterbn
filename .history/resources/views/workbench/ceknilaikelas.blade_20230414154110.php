@extends('layouts.master')
@push('css')
<style>
    .list-guru {
        list-style-type: none;
        position: absolute;
        width: 400px
    }

    .list-guru li a {
        padding: 20px;
        display: block;
        font-weight: bold;
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
                    <ul class="list-guru card p-2"></ul>
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
                }
                , type: "get"
                , dataType: 'json'
                , success: function(data) {
                    $.ajax({
  url: `https://api.randomuser.me/?name=${name}`,
  dataType: 'json',
  success: function(data) {
    // Extract the profile photo URL from the API response
    const profilePhotoUrl = data.results[0].picture.medium;

    // Create an image element and set the source to the profile photo URL
    const profilePhoto = $('<img>').attr('src', profilePhotoUrl);

    // Append the profile photo to a DOM element (e.g., an <img> tag)
    $('#profilePhoto').append(profilePhoto);
  },
  error: function(error) {
    console.error('Error fetching profile photo:', error);
  }
});
                    let li = data.map(function(e) {
                        return `<li>
                            <div>
                                <div class='row'>
                                    <div class='col-2'>
                                        <div class='icon-guru'>
                                            
                                        </div>
                                    </div>
                                    <div class='col-8'>
                                        <a>${e['name']}</a>
                                    </div>
                                </div>
                            </div>
                            </li> `
                    })
                    $(".list-guru").html(li);
                }
            })
        })
    })

</script>
@endpush
