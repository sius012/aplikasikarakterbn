{{-- <details>
<summary>Deskripsi</summary>
<p>fghjklkjhgfdfghjklkjhvcvbnm,kjhgvfvgbhnjmk,l.lkjhbgvfcfvghjklkjhbvcvbnm,mnbvcvbnm,mnbvcvbnm
    vbnm,nbvcbnm,.,mnbvbnm,.,mnbvbnm,
</p>
</details> --}}

<p class="title"><a href="#">Tags</a></p>

<input type="text" id="tag-input1">

(function(){
    this.tagsInput = function() {
      // Default state
      var defaults = {
        selector : '',
        max : null,
        duplicate: false,
        wrapperClass : 'tags-input-wrapper',
        tagClass : 'tag'
      }
  
      // Initialize elements
      this.arr = [];
      this.input = document.createElement('input');
      this.wrapper = document.createElement('div');
      if(arguments[0] && typeof arguments[0]  === "object") {
        this.options = Object.assign(defaults, arguments[0]);
      }
      this.original_input = document.getElementById(this.options.selector);
      
      buildUI.call(this);
      addEvents.call(this);
      
  
      // Building UI Elements
      function buildUI() {
        this.wrapper.append(this.input);
        this.wrapper.classList.add(this.options.wrapperClass);
        this.original_input.setAttribute('hidden', 'true');
        this.original_input.parentNode.insertBefore(this.wrapper, this.original_input);
      }
  
      // Initialize Events
      function addEvents() {
        var _ = this;
        this.wrapper.addEventListener('click', function() {
          _.input.focus();
        });
  
        this.input.addEventListener('keydown', function(event) {
          var str = _.input.value.trim();
          if (!!(~[9, 13, 188].indexOf(event.keyCode))) {
            _.input.value = "";
            if(str != "") {
              _.addTag(str);
            }
          }
        });
      }
  
      // Add Tag
      tagsInput.prototype.addTag = function(string) {
        if(this.anyErrors(string)) return;
  
        this.arr.push(string);
        var tagInput = this;
  
        var tag = document.createElement('span');
        tag.className = this.options.tagClass;
        tag.textContent = string;
  
        var closeIcon = document.createElement('a');
        closeIcon.innerHTML = '&times;';
        closeIcon.addEventListener('click', function(event) {
          event.preventDefault();
          var tag = this.parentNode;
  
          for(var i =0 ;i < tagInput.wrapper.childNodes.length ; i++){
            if(tagInput.wrapper.childNodes[i] == tag)
              tagInput.deleteTag(tag , i);
          }
        });
  
        tag.appendChild(closeIcon);
        this.wrapper.insertBefore(tag, this.input);
  
        this.original_input.value = this.arr.join(',');
        return this;
      }
  
      // Delete Tag
      tagsInput.prototype.deleteTag = function(tag, i) {
        tag.remove();
        this.arr.splice(i, 1);
        this.original_input.value = this.arr.join(',');
        return this;
      }
  
      // Errors
      tagsInput.prototype.anyErrors = function(string) {
        if( this.options.max != null && this.arr.length >= this.options.max) {
          console.log('Max tags limit reached');
          return true;
        }
  
        if(!this.options.duplicate && this.arr.indexOf(string) != -1 ){
          console.log('duplicate found " '+string+' " ')
          return true;
        }
  
        return false;
      }
  
  
      tagsInput.prototype.addData = function(array){
        var plugin = this;
  
        array.forEach(function(string){
          plugin.addTag(string);
        })
        return this;
      }
    }
  }())
  
  
  var tagInput1 = new tagsInput({
    selector: 'tag-input1',
    duplicate : false,
    max : 10
  });
  
  tagInput1.addData(['PHP' , 'JavaScript' , 'CSS']);
  
  
  