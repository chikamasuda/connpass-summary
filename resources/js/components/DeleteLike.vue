<template>
  <button 
  type="button" 
  class="btn btn-danger"
  @click="deleteLike"
  >
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
      this.unlike()
    },
    async unlike() {
      await axios.delete(this.endpoint)
      const card = document.getElementById('event-card-' + this.index);
      card.remove();
    },
  },
}
</script>