<template>
  <button 
  type="button" 
  class="m-0 p-0 btn shadow-none like-button"
  :class="{'liked': this.isLikedBy}"
  @click="clickLike"
  >
    <i class="fa fa-fw fa-heart"></i>
    お気に入り
  </button>
</template>

<script>
export default {
  props: {
    initialIsLikedBy: {
      type: Boolean,
      default: false,
    },
    endpoint: {
      type: String,
    }
  },
  data() {
    return {
      isLikedBy: this.initialIsLikedBy,
    }
  },
  methods: {
    clickLike () {
      //お気に入り済みの場合はお気に入り削除のメソッド、お気に入りがまだの場合はお気に入りするメソッドへ
      this.isLikedBy ? this.unlike() : this.like()
    },
    async like() {
      const response = await axios.put(this.endpoint)
      this.isLikedBy = true
    },
    async unlike() {
      const response = await axios.delete(this.endpoint)
      this.isLikedBy = false
    },
  },
}
</script>

