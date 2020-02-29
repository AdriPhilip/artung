<template>
  <div id="app">
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',
};
</script>

<style lang="scss">
//Import de Bootstrap et du fichier de modification des variables pour y accéder dans toute l'application.
@import '../../assets/css/custom.scss';
@import '../../node_modules/bootstrap/scss/bootstrap.scss';
#app {
  min-height: 100vh;
  background-color: var(--black);
}
</style>
