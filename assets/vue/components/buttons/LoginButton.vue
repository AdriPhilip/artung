<template>
  <div>
    <button
      class="loginButton"
      @click="$emit('onClick')"
    >
      <img
        src="../../../img/Arrow.svg"
        alt="right arrow of login button"
        :style="styleObject"
      >
    </button>
  </div>
</template>

<script>
export default {
  name: "LoginButton",
  props: {
    inverted: {
      type: String,
      default: "0"
    }
  },
  computed: {
    styleObject() {
      return { transform: 'rotate(' + this.inverted + 'deg)' };
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.loginButton {
  height: 36px;
  width: 36px;
  background-color: var(--black);
  border-radius: 50%;
  border: 2px solid var(--primary);
}
.loginButton > img{
  margin-left: -3px;
}
</style>
