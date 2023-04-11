{{-- <details>
<summary>Deskripsi</summary>
<p>fghjklkjhgfdfghjklkjhvcvbnm,kjhgvfvgbhnjmk,l.lkjhbgvfcfvghjklkjhbvcvbnm,mnbvcvbnm,mnbvcvbnm
    vbnm,nbvcbnm,.,mnbvbnm,.,mnbvbnm,
</p>
</details> --}}
<style>
    .tag {
  display: inline-block;
  background-color: #e0e0e0;
  padding: 5px 10px;
  margin-right: 5px;
  margin-bottom: 5px;
  border-radius: 10px;
}

.remove-tag {
  color: #ffffff;
  background-color: #333333;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  display: inline-block;
  text-align: center;
  margin-left: 5px;
  cursor: pointer;
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<input type="text" id="tag-input">

<div class="tag-container"></div>

<script>
    $('#tag-input').on('keydown', function(event) {
  if (event.keyCode === 13) { // jika user menekan tombol enter
    var tag = $(this).val(); // ambil nilai tag yang dimasukkan oleh user
    $(this).val(''); // kosongkan input tag
    $('.tag-container').append('<div class="tag">' + tag + '<span class="remove-tag">x</span></div>'); // tambahkan tag ke dalam container
  }
});

</script>