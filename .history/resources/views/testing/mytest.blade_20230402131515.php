{{-- <details>
<summary>Deskripsi</summary>
<p>fghjklkjhgfdfghjklkjhvcvbnm,kjhgvfvgbhnjmk,l.lkjhbgvfcfvghjklkjhbvcvbnm,mnbvcvbnm,mnbvcvbnm
    vbnm,nbvcbnm,.,mnbvbnm,.,mnbvbnm,
</p>
</details> --}}

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