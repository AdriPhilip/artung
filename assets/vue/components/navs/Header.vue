<template>
  <div>
    <nav>
      <!-- Logo ; permet de retourner au catalogue ; ne s'affiche que dans le parcours fan -->
      <img
        v-show="$route.name=='Catalog'|$route.name=='ArtistDetails'|$route.name=='FanAccount'"
        src="../../../img/artung_logo.png"
        alt="logo de l'application Artung"
        @click="$router.push({ name: 'Catalog' })"
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
  methods: {
    routerPush(name, params) {
      this.$router.push({ name: name, params: params });
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
