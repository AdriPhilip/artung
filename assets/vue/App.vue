<template>
  <div id="app">
    <router-view />
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "App",
  computed: {
    isAuthenticated() {
      return this.$store.getters["security/isAuthenticated"];
    }
  },
  created() {
    let isAuthenticated = JSON.parse(
        this.$parent.$el.attributes["data-is-authenticated"].value
      ),
      user = JSON.parse(this.$parent.$el.attributes["data-user"].value);

    let payload = { isAuthenticated: isAuthenticated, user: user };
    this.$store.dispatch("security/onRefresh", payload);

    axios.interceptors.response.use(undefined, err => {
      return new Promise(() => {
        if (err.response.status === 401) {
          this.$router.push({ path: "/login" });
        }
        throw err;
      });
    });
  }
};
</script>

<style lang="scss">
//Import de Bootstrap et du fichier de modification des variables pour y accéder dans toute l'application.
@import "../../assets/css/custom.scss";
@import "../../node_modules/bootstrap/scss/bootstrap.scss";
#app {
  min-height: 100vh;
  padding: var(--spacing-md);
  background-color: var(--black);
}
</style>
