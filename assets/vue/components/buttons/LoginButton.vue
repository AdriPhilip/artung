<template>
  <div>
    <button
      class="loginButton"
      @click="$emit('onClick')"
    >
      <img
        src="../../../img/Arrow.svg"
        alt="right arrow of login button"
      >
    </button>
  </div>
</template>

<script>
export default {
  name: "LoginButton"
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.loginButton {
  height: 36px;
  width: 36px;
  background-color: #131b23;
  border-radius: 50%;
  border: 2px solid #db5c4d;
}

.loginButton > img{
  margin-left: -3px;
}

</style>
