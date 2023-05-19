<div class="row">
    <div class="container p-3">
        <form action="" method="GET" >
            <div class="card p-4">
                <div class="row">
                    <div class="col-4">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" name="nama">
                    </div>
                    <div class="col-2">
                        <label for="">Dari</label>
                        <input type="date" class="form-control" name="dari">
                    </div>
                    <div class="col-2">
                        <label for="">Sampai</label>
                        <input type="date" class="form-control" name="sampai">
                    </div>
                    <div class="col-2">
                        <label for="">Kategori</label>
                        <select  id="" class="form-control" name="kategori">
                            @foreach($kategori as $kt)
                            <option value="{{$kt->id_kategori}}">{{$kt->kategori}} ({{$kt->tindakan}})</option>
                            @endforeach
                          
                        </select>
                    </div>
                    <div class="col-2">
                        <br>
                        <button class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </div>
           
        </form>
    </div>
</div>