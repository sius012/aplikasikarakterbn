{{-- <details>
<summary>Deskripsi</summary>
<p>fghjklkjhgfdfghjklkjhvcvbnm,kjhgvfvgbhnjmk,l.lkjhbgvfcfvghjklkjhbvcvbnm,mnbvcvbnm,mnbvcvbnm
    vbnm,nbvcbnm,.,mnbvbnm,.,mnbvbnm,
</p>
</details> --}}

<div class="input-container">
    <input type="text" id="myInput" placeholder="Tambahkan tag">
    <span class="clear-input">x</span>
  </div>

  <script type="">
    const input = document.querySelector('#myInput');
const clearButton = document.querySelector('.clear-input');

clearButton.addEventListener('click', function() {
  input.value = '';
});

input.addEventListener('input', function() {
  if (input.value.length > 0) {
    clearButton.style.display = 'block';
  } else {
    clearButton.style.display = 'none';
  }
});

  </script>
  
  