{{-- <details>
<summary>Deskripsi</summary>
<p>fghjklkjhgfdfghjklkjhvcvbnm,kjhgvfvgbhnjmk,l.lkjhbgvfcfvghjklkjhbvcvbnm,mnbvcvbnm,mnbvcvbnm
    vbnm,nbvcbnm,.,mnbvbnm,.,mnbvbnm,
</p>
</details> --}}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<style>
    .tag-input {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  width: 100%;
  height: 50px;
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 10px;
}

#tag-input-field {
  flex-grow: 1;
  border: none;
  outline: none;
}

#tag-container {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
  margin-left: 5px;
}

.tag {
  display: inlin;
  align-items: center;
  background-color: #e6e6e6;
  padding: 5px;
  border-radius: 5px;
  float: left;
}

.tag-name {
  margin-right: 5px;
}

.tag-close {
  cursor: pointer;
  color: red;
  float: right;
}

</style>

<div class="tag-input">
    <input type="text" id="tag-input-field">
    <div id="tag-container"></div>
  </div>

  <script>
  $(document).ready(function() {
  const $tagInput = $('#tag-input-field');
  const $tagContainer = $('#tag-container');

  $tagInput.on('keydown', function(event) {
    if (event.code === 'Comma' || event.code === 'Enter') {
      event.preventDefault();
      const $tag = $('<div/>', {class: 'tag'});
      const $tagName = $('<span/>', {class: 'tag-name', text: $tagInput.val().trim()});
      const $tagClose = $('<span/>', {class: 'tag-close', text: 'x'});
      $tagClose.on('click', function() {
        $tag.remove();
      });
      $tag.append($tagName).append($tagClose);
      $tagContainer.append($tag);
      $tagInput.val('');
    }
  });
});


  </script>
  