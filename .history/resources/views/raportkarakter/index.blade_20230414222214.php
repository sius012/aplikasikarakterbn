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

    .list-guru-span {
        background-color: rgb(0, 255, 26);
        margin: 5px;
        padding: 10px;
        color: white;
        font-weight: bold;
        line-height: 0px;
        border-radius: 20px;
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
    <form action="{{route('eraport.generateraportkarakter')}}" method="GET" id="raportkarakter-form">
    <div class="card">
        <div class="card-header">
            <h5>Generate Raport Karakter</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="">Kelas</label>
                <select name="angkatan" id="" class="form-control" required>
                    @foreach($kelas as $k)
                        <option value="{{$k->id_angkatan}}">{{$k->kelas()}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="">Jurusan</label>
                <select name="jurusan" id="" class="form-control" required>
                    @foreach($jurusan as $j)
                        <option value="{{$j->id_jurusan}}">{{$j->jurusan}}</option>
                    @endforeach
                </select>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="" class="form-label">Dari</label>
                    <input type="date" name='dari' class="form-control" required>
                </div>
                <div class="col">
                    <label for="" class="form-label">Sampai</label>
                    <input type="date" name="sampai" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="semuaguru">
                <label class="form-check-label" for="exampleCheck1">Semua Guru</label>
              </div>
            <div class="row">
                <div class="col-sm">
                    <div class="containers">
                        <input type="text" class="form-control my-1" id="search-guru">
                        <ul class="list-guru card p-2"></ul>
                        <div class="container-guru" style="display: inline-block">

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
</form>
</div>

<div class="modal fade" tabindex="-1" id="raportkarakter-modal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Raport Karakter</h5>
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

@push('js')
<script>
    function renderlist(img, data) {

    }
    $(document).ready(function() {
        const modal = new bootstrap.Modal("#raportkarakter-modal");
        modal.show();
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
            let count = $(".container-guru").children(`div[data-id=${$(this).data('id')}]`).length;

            if (count < 1) {
                $(".container-guru").append(`
            <div class="list-guru-main d-inline-block m-1" data-id='${$(this).data('id')}'>   
                                <input type='hidden' name='listguru[]' value='${$(this).data('id')}'>
                                <span class='badge bg-gradient-primary'>${$(this).data('nama')}<i class='fa fa-times d-inline-block m-2 my-1 btn-delete-list'></i></span>
                            </div>`);


            }
            e.stopPropagation();

        })


        $(document).click(function() {
            $('.list-guru').hide();
        })

        $(".list-guru").click(function(e) {

        })

        $(document).delegate(".btn-delete-list", "click", function() {
            $(this).closest(".list-guru-main").remove();
        })

        
    })

</script>
@endpush
