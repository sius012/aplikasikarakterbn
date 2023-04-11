{{-- <details>
<summary>Deskripsi</summary>
<p>fghjklkjhgfdfghjklkjhvcvbnm,kjhgvfvgbhnjmk,l.lkjhbgvfcfvghjklkjhbvcvbnm,mnbvcvbnm,mnbvcvbnm
    vbnm,nbvcbnm,.,mnbvbnm,.,mnbvbnm,
</p>
</details> --}}
<style>
    .input-container {
  position: relative;
  display: inline-block;
}

input[type="text"] {
  padding: 8px 32px 8px 8px;
  border: none;
  border-bottom: 2px solid gray;
  background-image: url('icon_search.png');
  background-repeat: no-repeat;
  background-position: right center;
  background-size: 20px 20px;
  width: 200px;
  font-size: 16px;
}

.clear-input {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  cursor: pointer;
}

.clear-input:hover {
  color: red;
}

</style>
<div class="input-container">
    <input type="text" id="myInput" placeholder="Tambahkan tag">
    <span class="clear-input">x</span>
  </div>

  <script type="text/javascript">
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
  
  