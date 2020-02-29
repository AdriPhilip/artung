<template>
  <div>
    <nav>
      <!-- Logo ; permet de retourner au catalogue -->
      <img
        v-show="$route.name=='Catalog'|$route.name=='ArtistDetails'|$route.name=='FanAccount'"
        src="../../../img/artung_logo.png"
        alt="logo de l'application Artung"
        @click="routerLogo()"
      >
      <!-- Boutons de registration ; ne s'affichent que sur la page Home -->
      <TextButton
        v-show="$route.name=='Home'"
        text="Je suis artiste"
        secondary
        @onClick="routerPush('Register', {role: 'artist'})"
      />
      <TextButton
        v-show="$route.name=='Home'"
        text="Je veux suivre des artistes"
        @onClick="routerPush('Register', {role: 'fan'})"
      />
      <!-- Bouton d'aperçu de la page pour un artiste ; ne s'affiche que dans le parcours artiste -->
      <TextButton
        v-show="$route.name=='ArtistAccount'|$route.name=='ArtistPreview'"
        text="Aperçu de ma page"
        @onClick="routerPush('ArtistPreview', '')"
      />
      <!-- Barre de favoris ; ne s'affiche que dans le parcours fan -->
      <FavBar v-show="$route.name=='Catalog'|$route.name=='ArtistDetails'|$route.name=='FanAccount'" />
      <!-- Bouton de profil -->
      <AccountButton v-show="$route.name=='Catalog'|$route.name=='ArtistDetails'|$route.name=='FanAccount'|$route.name=='ArtistAccount'|$route.name=='ArtistPreview'" />
      <!-- Bouton de login ; ne s'affiche que sur la page Home -->
      <LoginButton
        v-show="$route.name=='Home'"
        @onClick="routerPush('Login', '')"
      />
    </nav>
  </div>
</template>

<script>
import AccountButton from '../buttons/AccountButton'
import TextButton from '../buttons/TextButton'
import LoginButton from '../buttons/LoginButton'
import FavBar from '../navs/FavBar'

export default {
  name: 'Header',
  components: {
    AccountButton,
    TextButton,
    LoginButton,
    FavBar,
  },
  computed: {
    // Récupère si le user est connecté
    isAuthenticated() {
      return this.$store.getters["security/isAuthenticated"]
    },
    // récupère le rôle du user connecté
    role() {
      if (this.isAuthenticated) return this.$store.getters["security/roles"][0];
      else return 'NO';
    }
  },
  methods: {
    // Routes de destination des TextButton
    routerPush(name, params) {
      this.$router.push({ name: name, params: params });
    },
    // Routes de destination du logo en fonction du rôle
    routerLogo() {
      if(this.role === "ROLE_FAN") this.$router.push({ name: "Catalog" });
      else this.$router.push({ name: "Home" });
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
