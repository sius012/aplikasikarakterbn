{{-- <details>
<summary>Deskripsi</summary>
<p>fghjklkjhgfdfghjklkjhvcvbnm,kjhgvfvgbhnjmk,l.lkjhbgvfcfvghjklkjhbvcvbnm,mnbvcvbnm,mnbvcvbnm
    vbnm,nbvcbnm,.,mnbvbnm,.,mnbvbnm,
</p>
</details> --}}

<div>
    <input type="text" id="input-tag" placeholder="Tambahkan tag...">
    <div id="tag-container"></div>
  </div>

  
  <script>
    const inputTag = document.getElementById('input-tag');
const tagContainer = document.getElementById('tag-container');
let tags = [];

inputTag.addEventListener('keyup', function(event) {
  if (event.key === 'Enter') {
    const newTag = inputTag.value;
    if (newTag) {
      tags.push(newTag);
      inputTag.value = '';
      renderTags();
    }
  }
});

function renderTags() {
  tagContainer.innerHTML = '';
  tags.forEach(function(tag) {
    const tagElement = document.createElement('span');
    tagElement.classList.add('tag');
    tagElement.innerText = tag;
    tagContainer.appendChild(tagElement);
  });
}

  </script>
  
  