{{-- <details>
<summary>Deskripsi</summary>
<p>fghjklkjhgfdfghjklkjhvcvbnm,kjhgvfvgbhnjmk,l.lkjhbgvfcfvghjklkjhbvcvbnm,mnbvcvbnm,mnbvcvbnm
    vbnm,nbvcbnm,.,mnbvbnm,.,mnbvbnm,
</p>
</details> --}}

<div id="app" class="bg-grey-lighter px-8 py-16 min-h-screen">
    <div class="max-w-sm w-full mx-auto">
      <tags-input v-model="tags"></tags-input>
    </div>
  </div>

  
<script>
    Vue.component('tags-input', {
  template: `
    <div class="tags-input">
      <span v-for="tag in value" class="tags-input-tag">
        <span>{{ tag }}</span>
        <button type="button" class="tags-input-remove" @click="removeTag(tag)">&times;</button>
      </span>
      <input class="tags-input-text" placeholder="Add tag..."
        @keydown.enter.prevent="addTag"
        v-model="newTag"
      >
    </div>
  `,
  props: ['value'],
  data() {
    return {
      newTag: '',
    }
  },
  methods: {
    addTag() {
      if (this.newTag.trim().length === 0 || this.value.includes(this.newTag.trim())) {
        return
      }
      this.$emit('input', [...this.value, this.newTag.trim()])
      this.newTag = ''
    },
    removeTag(tag) {
      this.$emit('input', this.value.filter(t => t !== tag))
    },
  },
})

new Vue({
  el: '#app',
  data: {
    tags: [
      'Testing',
      'Design',
    ],
  },
});

</script>