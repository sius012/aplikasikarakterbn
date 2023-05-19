@extends('layouts.master')
@section('title', "Kabar Beranda Karakterkuy")
@section('branch1', 'Depan')
@section('content')

<div class="container mt-4">
    @include('components.superApp.cardcatatanform')
    @foreach($catatan_sikap as $i => $cs)
    @include('components.superApp.cardcatatanlist')
    @endforeach

</div>


<div class="modal fade" tabindex="-1" id="tambah-catatan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Catatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('tambahcatatan')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="card-body">
                        <div class="container-fluid">
                            <input type="hidden" value="" class="nis-siswa" name="nis" required>
                            <div class="form-group p-0">
                                <p>Cari Siswa</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="card border p-2 siswa-field">
                                        <div class="card list-siswa position-absolute">

                                        </div>
                                    </div>
                                    <div class="col-md-6 siswa-cont">

                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="">Kategori</label>
                                    <select name="kategori" id="" class="form-control">
                                        @foreach($kategori as $key => $ktr)
                                        <option value="{{$ktr->id_kategori}}">{{$ktr->kategori}} ({{$ktr->tindakan}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <textarea name="keterangan" id="" cols="30" rows="4" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Lampiran</label>
                                <input type="file" class="form-control" name="lampiran">
                            </div>
                           
                        </div>
                   
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah Catatan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@section('outer')

<div class="fixed-plugin">
    <a class="fixed-plugin-button bg-primary text-light position-fixed px-3 py-2" data-bs-toggle="modal" data-bs-target="#tambah-catatan">
        <i class="fa fa-add py-2"> </i>
    </a>
</div>
@endsection

@push("js")
<script>
    $(".list-siswa").hide();
    $(".siswa-field").keyup(function() {
        $(".list-siswa").hide();
        var kw = $(this).val();
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content")
            }
            , url: "/listsiswa"
            , type: "get"
            , data: {
                kw: kw
            }
            , dataType: "json"
            , success: function(data) {
                $(".list-siswa").show();
                let siswa = data.map(function(e) {
                    return `
                    <a href="#" class='pilih-siswa' data-nama="${e["nama_siswa"]}" data-nis="${e["nis"]}">
                        <row>
                        <col></col>
                        <col>${e['nama_siswa']}</col>
                    </row>
                        </a>
                    
                    `;
                })

                $(".list-siswa").html(siswa)
            }
        })

        $(document).delegate(".pilih-siswa", "click", function() {

            $(".list-siswa").hide();
            $(".siswa-cont").html(`
                <div class='card'> <p class='p-1'>${$(this).data("nama")}</p></div>
               
            `)
            $(".nis-siswa").val($(this).data("nis"));
        })
    });

</script>
@endpush
