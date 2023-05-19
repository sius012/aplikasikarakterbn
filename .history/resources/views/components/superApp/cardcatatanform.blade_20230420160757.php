<div class="row">
    <div class="container p-3">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card p-4">
                <div class="row">
                    <div class="col-4">
                        <label for="">Nama</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-2">
                        <label for="">Dari</label>
                        <select name="" id="" class="form-control"></select>
                    </div>
                    <div class="col-2">
                        <label for="">Sampai</label>
                        <select name="" id="" class="form-control"></select>
                    </div>
                    <div class="col-2">
                        <label for="">Kategori</label>
                        <select name="" id="" class="form-control">
                            @foreach($kategori as $kt)
                            <option value="{{$kt->id_kategori}}">{{$kt->kategori}} </option>
                            @endforeach
                          
                        </select>
                    </div>
                </div>
            </div>
           
        </form>
    </div>
</div>