@extends('layouts.master')
@section('content')
<button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary">Tambah Kategori</button>
<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Aspek Terkait</th>
            <th>Perilaku</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kategori as $i => $k)
        <tr>
            <td>{{$i+1}}</td>
            <td>{{$k['kategori']->kategori}}</td>
            <td>@foreach($k['aspek'] as $a => $asp) {{$a}} @endforeach</td>
            <td>{{$k['kategori']->tindakan}}</td>
            <td><button class="btn btn-warning"><i class="fa fa-edit"></i></button></td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{route('admin.konfigurasiumum.kategori.tambah')}}" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">
                            Kategori
                        </label>
                        <input type="text" class="form-control" name="kategori" placeholder="Kategori" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label">
                            Tindakan
                        </label>
                        <select name='tindakan' class="form-control" required>
                            <option>Positif</option>
                            <option>Negatif</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Aspek Terkait</label>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Point</th>
                                    <th>Aspek</th>
                                    <th><button type="button" class="btn btn-primary btn-add-aspek"><i class="fa fa-plus"></i></button></th>
                                </tr>
                            </thead>
                            <tbody class="aspek-cont">

                            </tbody>
                        </table>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Buat</button>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection

@push("js")
<script>
    $(document).ready(function() {
        $(".btn-add-aspek").hide();
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr('content')
            }
            , type: "get"
            , url: ""
            , data: {
                requestJson: "yes"
            , }
            , dataType: "json"
            , success: function(data) {
                $(".btn-add-aspek").show();
                console.log(data);

                let opt = '<option>Pilih Aspek</option>';
                data.forEach(function(e, i) {
                    let opening = `<optgroup label='${e['point']}'>`

                    e.aspek.forEach(element => {
                        opening += `<option value='${element['id_aspek']}'  readonly>${element["keterangan"]}</option>`;
                    });

                    opening += "</optgroup>"

                    opt += opening

                });
                $(".aspek-cont").append(`
                <tr>
                    <td><input class='form-control asp-inp' readonly ></td>
                    <td><select name='id_aspek[]' class="form-control asp-select" id="first-select-asp">
                        ${opt}
                        </select></td>    
                </tr>
                `)


            }
            , error: function(err) {
                alert(err.responseText);
            }

        });

        $(".btn-add-aspek").click(function(e) {
            let opt = '<option>Pilih Aspek</option>';
            $("#first-select-asp optgroup").each(function(q) {
                let opening = `<optgroup label='${$(this).attr("label")}'>`
                
                $(this).children("option").each(function(){
                    opening += `<option value='${$(this).attr("value")}'>${$(this).text()}</option>`;
               
                });

                opening += "</optgroup>"

                opt += opening
            })
            $(".aspek-cont").append(`
                <tr>
                    <td><input class='form-control asp-inp' readonly></td>
                    <td><select class="form-control asp-select" name="id_aspek[]" id="first-select-asp">
                        ${opt}
                        </select></td>    
                        <td><button class='btn btn-danger btn-asp-hapus'><i class='fa fa-trash'></i></button></td>
                </tr>
                `)


        })

        $(document).delegate(".asp-select", "change", function(){
            var selectedOpt = $(this).find('option:selected');
            var optGroup = selectedOpt.closest("optgroup");
            var input = $(this).closest('tr').find(".asp-inp");
            input.val(optGroup.attr("label"));
        });

        $(document).delegate(".btn-asp-hapus", "click", function(){
            var input = $(this).closest('tr').remove()
        });
    });

</script>

@endpush
