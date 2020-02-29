<template>
  <div class="logo">
    <img
      src="../../img/artung_logo.png"
      alt="logo de l'application Artung"
      @click="$router.push({ name: 'Home' })"
    >
  </div>
</template>

<script>
export default {
  name: 'Logo',
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.logo {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}
.logo img {
  width: 70%;
  cursor: pointer;
}
@media (min-width: 768px) {
  .logo img {
    width: 50%;
  }
}
</style>
