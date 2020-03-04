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
    this.manageAuthOnRefresh();
    this.loadFbSdk("113324356787500", "v5.0").then(loadingResult => {
      console.log(loadingResult);
    });
  },
  methods: {
    manageAuthOnRefresh() {
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
    },
    // On charge le SDK facebook pour accéder à window.FB de n'importe où dans l'appli
    loadFbSdk(appId, version) {
      //window.appAccessToken =
      //  "113324356787500|a37482071c19a6e0555b5476d7a84d49";

      window.appAccessToken = "113324356787500|2nUUOk0wWhd5qUcWUUgCkiCH5E8";
      return new Promise(resolve => {
        window.fbAsyncInit = function() {
          // eslint-disable-line func-names
          window.FB.init({
            appId,
            xfbml: false,
            version,
            cookie: true
          });
          window.FB.AppEvents.logPageView();
          resolve("SDK Loaded!");
        };
        (function(d, s, id) {
          // eslint-disable-line func-names
          const fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) {
            return;
          }
          const js = d.createElement(s);
          js.id = id;
          js.src = "//connect.facebook.net/en_US/sdk.js";
          fjs.parentNode.insertBefore(js, fjs);
        })(document, "script", "facebook-jssdk");
      });
    }
  }
};
</script>

<style lang="scss">
//Import de Bootstrap et du fichier de modification des variables pour y accéder dans toute l'application.
@import "../../assets/css/custom.scss";
@import "../../node_modules/bootstrap/scss/bootstrap.scss";
#app {
  min-height: 100vh;
  padding: 0 var(--spacing-md);
  background-color: var(--black);
}
</style>
