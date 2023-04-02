<style>
    body {
        background: rgba(243 244 246);
        overflow: hidden;
    }

    .foto_posting {
        margin: -10px;
        height: 47em;
        width: 40em;
        cursor: pointer;
        transition: 0.3s;
    }

    .posting .file{
        display: none;
    }

    img:hover{
        opacity: 0.5;
    }

    .konten{
        margin-left: 50%;
        margin-top: -40%;
    }
</style>

<body>
    <label class="posting">
    <img class="foto_posting"
        src="https://img.freepik.com/free-photo/view-snowy-mountain-fir-trees-with-blue-sky-background_9083-8044.jpg">
    <input type="file" class="file">
    </label>

    <div class="konten">
       <form>
  <label for="nama">Nama:</label>

  <input type="text" class="form-control" id="nama" name="nama" list="nama-list">
  <datalist id="nama-list">
    <option value="Andi">
    <option value="Budi">
    <option value="Cici">
    <option value="Dodi">
  </datalist>
</form>

    </div>
    </body>
