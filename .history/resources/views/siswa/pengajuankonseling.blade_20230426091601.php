@extends('layouts.mastersiswa')
@section('content')
<div class="container">
    <h3>Cari Konselor</h3>
    
    <div class="row" id="container-konselor">
    </div>
</div>

<!-- Modal -->
@isset($detailjadwal)
<div class="modal fade" id="modal-sesi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('siswa.pengajuankonseling.store')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel" class="title-modal">Ajukan Konseling</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id-konselor" name="id_konselor">
                    <div class="form-group">
                        <label for="" class="form-label">Sesi Tersedia</label>
                        <select name="sesi" id="" class="form-control" required>
                            @foreach($detailjadwal as $i => $djk)
                              <optgroup label="{{getDayName($i)}}">
                                @foreach($djk as $j=> $d)
                                <option value="{{$d->id_djk}}">Jam {{$d->dari}} - {{$d->sampai}} ({{getDayName($i)}})</option>
                                @endforeach
                              </optgroup>
                               
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <textarea name="keterangan" id="" cols="30" rows="4" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Ajukan Konseling</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@push("js")
@isset($detailjadwal)
<script>
    $(document).ready(function() {
        var modalsesi = new bootstrap.Modal($("#modal-sesi"), {
            keyboard: false
        });

        modalsesi.show();
    })

</script>
@endisset
@endpush
@endsection
