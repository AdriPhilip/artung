<template>
  <div>
    <nav>
      <!-- Logo ; permet de retourner au catalogue -->
      <img
        v-show="$route.name === 'Home' || ($route.name === 'ArtistDetails' && role !== 'ROLE_ARTIST') || $route.name === 'FanAccount'"
        src="../../../img/artung_logo.png"
        alt="logo de l'application Artung"
        title="Retour à l'accueil"
        @click="routerPush('Home', '')"
      >
      <!-- Boutons de registration ; ne s'affichent que si non connecté -->
      <TextButton
        v-show="!isAuthenticated && $route.name !== 'Login' && $route.name !== 'Register'"
        text="Je suis artiste"
        class="marginButton"
        secondary
        @onClick="routerPush('Register', {role: 'artist'})"
      />
      <TextButton
        v-show="!isAuthenticated && $route.name !== 'Login' && $route.name !== 'Register'"
        text="Je veux suivre des artistes"
        class="marginButton"
        @onClick="routerPush('Register', {role: 'fan'})"
      />
      <!-- Bouton d'aperçu de la page pour un artiste ; ne s'affiche que dans le parcours artiste -->
      <TextButton
        v-show="role === 'ROLE_ARTIST'"
        text="Aperçu de ma page"
        class="apercuMarginButton"
        secondary
        @onClick="routerPush('ArtistDetails', { id: user.artist.id, artist: user.artist })"
      />
      <!-- Barre de favoris ; ne s'affiche que dans le parcours fan -->
      <FavBar v-if="role === 'ROLE_FAN'" />
      <!-- Bouton de profil ; ne s'affiche que si connecté -->
      <AccountButton
        v-if="isAuthenticated"
        class="accountMarginButton"
        @onClick="goToAccount()"
      />
      <!-- Bouton de login ; ne s'affiche que si non connecté -->
      <LoginButton
        v-show="!isAuthenticated && $route.name !== 'Login' && $route.name !== 'Register'"
        class="loginMarginButton"
        @onClick="routerPush('Login', '')"
      />
      <!-- Bouton de retour ; ne s'affiche que sur les pages login et register -->
      <LoginButton
        v-show="$route.name === 'Login' || $route.name === 'Register'"
        class="loginMarginButton"
        inverted="180"
        @onClick="routerPush('Home', '')"
      />
    </nav>
  </div>
</template>

<script>
import AccountButton from "../buttons/AccountButton";
import TextButton from "../buttons/TextButton";
import LoginButton from "../buttons/LoginButton";
import FavBar from "../navs/FavBar";

export default {
  name: "Header",
  components: {
    AccountButton,
    TextButton,
    LoginButton,
    FavBar
  },
  data() {
    return {
      accountInfo: ""
    };
  },
  computed: {
    // Récupère si le user est connecté
    isAuthenticated() {
      return this.$store.getters["security/isAuthenticated"];
    },
    // récupère le rôle du user connecté
    role() {
      if (this.isAuthenticated) return this.$store.getters["security/roles"][0];
      else return "NO";
    },
    // Récupère les infos du user dans le Store
    user() {
      if (this.isAuthenticated) return this.$store.getters["security/user"];
      else return null;
    }
  },
  methods: {
    // Routes de destination des TextButton
    routerPush(name, params) {
      this.$router.push({ name: name, params: params });
    },
    goToAccount() {
      if (this.role === "ROLE_FAN") {
        this.$router.push({ name: "FanAccount" });
      } else if (this.role === "ROLE_ARTIST") {
        this.$router.push({ name: "ArtistAccount" });
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
nav {
  display: flex;
  align-items: center;
  margin: var(--spacing-sm) 0;
}
nav img {
  width: 56px;
  padding: var(--spacing-md);
  height: 56px;
  cursor: pointer;
}
/* Espacement entre les boutons du Header */
.marginButton {
  margin-right: var(--spacing-md);
}
.accountMarginButton {
  margin-left: var(--spacing-md);
}
.loginMarginButton {
  margin-left: auto;
}
.apercuMarginButton {
  margin-right: auto;
}
</style>
