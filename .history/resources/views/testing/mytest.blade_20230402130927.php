{{-- <details>
<summary>Deskripsi</summary>
<p>fghjklkjhgfdfghjklkjhvcvbnm,kjhgvfvgbhnjmk,l.lkjhbgvfcfvghjklkjhbvcvbnm,mnbvcvbnm,mnbvcvbnm
    vbnm,nbvcbnm,.,mnbvbnm,.,mnbvbnm,
</p>
</details> --}}


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
  display: flex;
  align-items: center;
  background-color: #e6e6e6;
  padding: 5px;
  border-radius: 5px;
}

.tag-name {
  margin-right: 5px;
}

.tag-close {
  cursor: pointer;
}

</style>

<div class="tag-input">
    <input type="text" id="tag-input-field">
    <div id="tag-container"></div>
  </div>

  
  