<template>
  <div>
    <div class="topBar">
      <Header />
    </div>
    <div class="loginForm">
      <form
        class="mx-5 p-5"
        @submit.prevent
      >
        <FormGroup
          v-model="login"
          form-group="emailInput"
          type="email"
          text="Email"
          placeholder="Votre adresse e-mail"
        />
        <FormGroup
          v-model="password"
          form-group="passwordInput"
          type="password"
          text="Mot de passe"
        />
        <div class="d-flex justify-content-center pt-5">
          <TextButton
            text="Go !"
            form
            @onClick="performLogin()"
          />
        </div>
      </form>
      <div class="d-flex justify-content-center mt-3">
        <div v-if="isLoading">
          <p class="text-light">
            Connexion en cours...
          </p>
        </div>

        <div v-else-if="hasError">
          <div
            class="alert alert-danger"
            role="alert"
          >
            {{ error }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Header from "../components/navs/Header";
import FormGroup from "../components/forms/FormGroup";
import TextButton from "../components/buttons/TextButton";

export default {
  name: "Login",
  components: {
    Header,
    FormGroup,
    TextButton
  },
  data() {
    return {
      login: "",
      password: "",
      error: ""
    };
  },
  computed: {
    isLoading() {
      return this.$store.getters["security/isLoading"];
    },
    hasError() {
      return this.$store.getters["security/hasError"];
    }
  },
  methods: {
    async performLogin() {
      let payload = { login: this.login, password: this.password };
      await this.$store.dispatch("security/login", payload, { root: true });
      if (!this.$store.getters["security/hasError"]) {
        let roles = this.$store.getters["security/roles"];
        if (roles.includes("ROLE_ARTIST")) {
          this.$router.push({ path: "/artist/account" });
        } else if (roles.includes("ROLE_FAN")) {
          this.$router.push({ path: "/home" });
        } else {
          console.log("Le rôle n'est pas défini dans l'API");
        }
      } else {
        let responseError = this.$store.getters["security/error"];
        if (responseError.response.status == 401) {
          this.error =
            "Connexion impossible. Les informations entrées n'ont pas permis l'authentification.";
        } else {
          this.error =
            "Connexion impossible. Erreur " +
            this.$store.getters["security/error"];
        }
      }
    }
  }
};
</script>

<style scoped>
.topBar {
  padding: var(--spacing-md) 0;
}
.loginForm {
  padding-top: var(--spacing-lg);
}
</style>
