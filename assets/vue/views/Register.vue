<template>
  <div>
    <form
      class="m-5 p-5"
      @submit.prevent
    >
      <FormGroup
        v-model="login"
        form-group="emailInput"
        type-status="email"
        text="Email"
        placeholder="nom@nom-de-domaine.com"
      />
      <FormGroup
        v-model="nickname"
        form-group="nicknameInput"
        type-status="text"
        text="Nom d'utilisateur"
      />
      <FormGroup
        v-model="password"
        form-group="passwordInput"
        type-status="password"
        text="Mot de passe"
      />

      <FormGroup
        v-model="passwordConfirm"
        form-group="confirmPasswordInput"
        type-status="password"
        text="Confirmer le mot de passe"
      />
      <div
        v-if="error"
        class="alert alert-danger"
      >
        {{ error }}
      </div>
      <TextButton
        text="Go !"
        form
        @onClick="register()"
      />
      <div v-if="loading">
        <p class="text-light">
          Connexion en cours...
        </p>
      </div>
    </form>
  </div>
</template>

<script>
import FormGroup from "../components/forms/FormGroup";
import TextButton from "../components/buttons/TextButton";

export default {
  name: "Register",
  components: {
    FormGroup,
    TextButton
  },
  data() {
    return {
      login: "",
      password: "",
      passwordConfirm: "",
      nickname: "",
      error: "",
      loading: false
    };
  },
  methods: {
    async register() {
      if (this.checkPassword()) {
        // Récupération du type de compte à partir de la route
        let type = this.$route.params.role;
        let data = {
          username: this.login,
          password: this.password,
          nickname: this.nickname
        };
        this.loading = true;
        try {
          // On commence par créer un nouvel utilisateur
          await fetch("/api/registration/" + type, {
            method: "POST",
            headers: {
              Accept: "application/json",
              "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
          })
            .then(response => response.json())
            .then(
              user => {
                let payload = {
                  login: user.login,
                  password: this.password
                };
                // Puis on le login.
                this.performLogin(payload);
              },
              error => {
                console.log("Erreur lors de la connexion : " + error);
              }
            );
        } catch (error) {
          this.error =
            "Impossible de créer un compte, erreur : " + error.message;
        }
      }
    },
    route() {
      if (this.$route.params.role === "artist")
        this.$router.push({ name: "ArtistAccount", params: "" });
      else if (this.$route.params.role === "fan")
        this.$router.push({ name: "Catalog", params: "" });
    },
    checkPassword() {
      if (this.password == "" || this.passwordConfirm == "") {
        this.error = "Veuillez remplir les champs";
      } else {
        if (this.password == this.passwordConfirm) {
          return true;
        } else {
          this.error = "Les mots de passe entrés sont différents";
          return false;
        }
      }
    },
    async performLogin(payload) {
      await this.$store.dispatch("security/login", payload, { root: true });
      if (!this.$store.getters["security/hasError"]) {
        let roles = this.$store.getters["security/roles"];
        if (roles.includes("ROLE_ARTIST")) {
          this.$router.push({ path: "/artist/account" });
        } else if (roles.includes("ROLE_FAN")) {
          this.$router.push({ path: "/fan" });
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
            "Connexion impossible. " + this.$store.getters["security/error"];
        }
      }
    }
  }
};
</script>

<style lang="scss">
</style>
