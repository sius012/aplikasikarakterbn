{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<style>
 *{
    margin: 5px;
 }

 .tag {
  background-color: #3f51b5;
  color: white;
  padding: 5px;
  border-radius: 5px;
  margin-right: 5px;
  margin-bottom: 5px;
  display: inline-block;
  cursor: pointer;
}

</style>

<form action="/tambah_siswa" method="POST">
    @csrf
<div class="tag-input">
  <input type="text" id="tag-input-field" placeholder="Tambahkan tag" list="siswa-list">
  <div class="tag-container"></div>
  <input type="hidden" name="tags" id="tags-input" value="">

  <datalist id="siswa-list">
    <option value="Andi">
    <option value="Budi">
    <option value="Miki">
  </datalist>
</div>


<button>OK</button>

</form>
<script>
    $(document).ready(function() {
    var tags = [];

    $('#tag-input-field').keydown(function(event) {
        var tagInput = $(this).val();
        if (event.keyCode === 13 || event.keyCode === 188) { // Check for enter or comma key
        event.preventDefault();
        if (tagInput.length > 0) {
            addTag(tagInput);
            $(this).val('');
        }
        }
    });

  function addTag(tagInput) {
    var tag = $('<span class="tag">' + tagInput + '<span class="remove-tag">&times;</span></span>');
    $('.tag-container').append(tag);
    tags.push(tagInput);
    $('#tags-input').val(tags.join(','));
  }

  $(document).on('click', '.remove-tag', function() {
    var tag = $(this).parent('.tag');
    var tagIndex = $('.tag').index(tag);
    tags.splice(tagIndex, 1);
    tag.remove();
    $('#tags-input').val(tags.join(','));
  });
});


</script> --}}

{{-- <form id="upload-form" action="/postingan" method="POST" enctype="multipart/form-data">
  <label for="file-input">Pilih file:</label>
  <input type="file" id="file-input" name="file">
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(function() {
    $('#file-input').on('change', function() {
      // Mendapatkan nama file
      
      // Mengirim form ke server
      $('#upload-form').submit();
      
      
    });
  });
</script> --}}

