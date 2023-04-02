{{-- <details>
<summary>Deskripsi</summary>
<p>fghjklkjhgfdfghjklkjhvcvbnm,kjhgvfvgbhnjmk,l.lkjhbgvfcfvghjklkjhbvcvbnm,mnbvcvbnm,mnbvcvbnm
    vbnm,nbvcbnm,.,mnbvbnm,.,mnbvbnm,
</p>
</details> --}}

<style>
    .tag-container {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  border: 1px solid #ccc;
  padding: 10px;
}

input[type="text"] {
  flex: 1;
  border: none;
  outline: none;
  padding: 0;
  margin: 0;
}

.tags {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  margin-top: 10px;
}

.tag {
  background-color: #ccc;
  color: #fff;
  border-radius: 3px;
  padding: 3px 6px;
  margin: 3px;
}

.tag-close{
    cursor: pointer;
    margin: 5px;
    color: red;
}

</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<div class="tag-container">
    <input type="text" placeholder="Add tags..." list="nama-">
    <datalist id="nama-list">
        <option value="Andi">
        <option value="Budi">
        <option value="Cici">
        <option value="Dodi">
      </datalist>
    <div class="tags"></div>
  </div>
  
  <script>
    $(function() {
  var tagContainer = $('.tags');
  
  $('.tag-container input').on('keydown', function(event) {
    if (event.keyCode === 13 || event.keyCode === 188) {
      event.preventDefault();
      var tag = $('<div/>', { class: 'tag' });
      var tagName = $('<span/>', { class: 'tag-name', text: $(this).val().trim() });
      var tagClose = $('<span/>', { class: 'tag-close', text: 'x' });
      
      tagClose.on('click', function() {
        $(this).parent().remove();
      });
      
      tag.append(tagName);
      tag.append(tagClose);
      tagContainer.append(tag);
      
      $(this).val('');
    }
  });
});

  </script>