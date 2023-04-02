{{-- <details>
<summary>Deskripsi</summary>
<p>fghjklkjhgfdfghjklkjhvcvbnm,kjhgvfvgbhnjmk,l.lkjhbgvfcfvghjklkjhbvcvbnm,mnbvcvbnm,mnbvcvbnm
    vbnm,nbvcbnm,.,mnbvbnm,.,mnbvbnm,
</p>
</details> --}}
<style>
    .tag {
  display: inline-block;
  padding: 4px 8px;
  background-color: #eee;
  border-radius: 4px;
  margin-right: 8px;
  margin-bottom: 8px;
}

.remove-tag-button {
  color: #888;
  text-decoration: none;
  margin-left: 8px;
}

.remove-tag-button:hover {
  color: #333;
}

</style>

<input type="text" id="tag-input" list="tags">
<datalist id="tags">
  <option value="Music">
  <option value="Comedy">
  <option value="Gaming">
  <option value="Technology">
</datalist>


<button id="add-tag-button">Add Tag</button>

<div id="tag-list">
    <span class="tag">Music <a href="#" class="remove-tag-button">×</a></span>
    <span class="tag">Gaming <a href="#" class="remove-tag-button">×</a></span>
  </div>
  
  
<script>
    const tagInput = document.getElementById('tag-input');
const addTagButton = document.getElementById('add-tag-button');
const tagList = document.getElementById('tag-list');

addTagButton.addEventListener('click', function() {
  const tagValue = tagInput.value.trim();
  if (tagValue !== '') {
    const tagElement = document.createElement('span');
    tagElement.className = 'tag';
    tagElement.textContent = tagValue;
    const removeTagButton = document.createElement('a');
    removeTagButton.className = 'remove-tag-button';
    removeTagButton.href = '#';
    removeTagButton.textContent = '×';
    tagElement.appendChild(removeTagButton);
    tagList.appendChild(tagElement);
    tagInput.value = '';
  }
});

tagList.addEventListener('click', function(event) {
  if (event.target.classList.contains('remove-tag-button')) {
    const tagElement = event.target.parentElement;
    tagList.removeChild(tagElement);
  }
});

</script>
  