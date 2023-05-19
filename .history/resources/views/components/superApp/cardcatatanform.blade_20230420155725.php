<div class="row">
    <div class="container p-3">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf

            <label for="" class="fw-bold mb-3">Pilih Kategori</label>
            <label for="" class="fw-bold mb-3">Keterangan</label>
            <textarea name="keterangan" id="" cols="30" rows="2" class="form-control mb-3" placeholder="Tambahkan catatan" required></textarea>
            <label for="" class="fw-bold mb-3">Lampiran</label>
            <input name="lampiran" type="file" accept="img" class="form-control mb-3" required>
            <label for="" class="fw-bold mb-3">Visibilitas</label>
            <select name="visibilitas" id="" class="form-control" required>
                <option value="Asrama">Asrama</option>
                <option value="Sekolah">Sekolah</option>
                <option value="Semua">Semua</option>
            </select>
            <button class="btn btn-primary my-2">Buat</button>
        </form>
    </div>
</div>