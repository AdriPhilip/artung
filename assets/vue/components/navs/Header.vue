<template>
  <div>
    <nav>
      <!-- Logo ; permet de retourner au catalogue -->
      <img
        v-show="$route.name=='Home'|$route.name=='ArtistDetails'|$route.name=='FanAccount'"
        src="../../../img/artung_logo.png"
        alt="logo de l'application Artung"
        @click="routerPush('Home', '')"
      >
      <!-- Boutons de registration ; ne s'affichent que si non connecté -->
      <TextButton
        v-if="!isAuthenticated"
        text="Je suis artiste"
        secondary
        @onClick="routerPush('Register', {role: 'artist'})"
      />
      <TextButton
        v-if="!isAuthenticated"
        text="Je veux suivre des artistes"
        @onClick="routerPush('Register', {role: 'fan'})"
      />
      <!-- Bouton d'aperçu de la page pour un artiste ; ne s'affiche que dans le parcours artiste -->
      <TextButton
        v-show="$route.name=='ArtistAccount' || $route.name=='ArtistPreview'"
        text="Aperçu de ma page"
        secondary
        @onClick="routerPush('ArtistPreview', { artist: user.artist })"
      />
      <!-- Barre de favoris ; ne s'affiche que dans le parcours fan -->
      <FavBar v-if="role === 'ROLE_FAN'" />
      <!-- Bouton de profil ; ne s'affiche que si connecté -->
      <AccountButton
        v-if="isAuthenticated"
        @onClick="goToAccount()"
      />
      <!-- Bouton de login ; ne s'affiche que si non connecté -->
      <LoginButton
        v-if="!isAuthenticated"
        @onClick="routerPush('Login', '')"
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
  padding: 5px;
}
nav img {
  width: 56px;
  height: 56px;
  cursor: pointer;
}
</style>
