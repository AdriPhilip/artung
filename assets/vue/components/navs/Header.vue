<template>
  <div>
    <nav>
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
      <TextButton
        v-show="$route.name=='ArtistAccount'|$route.name=='ArtistPreview'"
        text="Aperçu de ma page"
        @onClick="routerPush('ArtistPreview', '')"
      />
      <FavBar v-show="$route.name=='Catalog'|$route.name=='ArtistDetails'|$route.name=='FanAccount'" />
      <AccountButton v-show="$route.name=='Catalog'|$route.name=='ArtistDetails'|$route.name=='FanAccount'|$route.name=='ArtistAccount'|$route.name=='ArtistPreview'" />
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
</style>
