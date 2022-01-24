<template>
  <button 
  type="button" 
  class="m-0 p-0 btn shadow-none trash"
  @click="deleteLike()"
  >
    <i class="fa fa-fw fa-trash"></i>
    削除する
  </button>
</template>

<script>

export default {
  props: {
    endpoint: {
      type: String,
    },
    index: {
      type: String,
    }
  },
  methods: {
    deleteLike() {
      if (confirm('お気に入りを削除してもよろしいですか?')) {
        this.unlike()
      }
    },
    async unlike() {
      await axios.delete(this.endpoint)
      const card = document.getElementById('event-card-' + this.index);
      card.remove();
    }
  },
}
</script>