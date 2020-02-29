<template>
  <div>
    <nav>
      <TextButton
        v-show="$route.name=='Home'"
        text="Je suis artiste"
        route="Register"
        :params="{role: 'artist'}"
        secondary
      />
      <TextButton
        v-show="$route.name=='Home'"
        text="Je veux suivre des artistes"
        route="Register"
        :params="{role: 'fan'}"
      />
      <TextButton
        v-show="$route.name=='ArtistAccount'|$route.name=='ArtistPreview'"
        text="Aperçu de ma page"
        route="ArtistPreview"
      />
      <FavBar v-show="$route.name=='Catalog'|$route.name=='ArtistDetails'|$route.name=='FanAccount'" />
      <AccountButton v-show="$route.name=='Catalog'|$route.name=='ArtistDetails'|$route.name=='FanAccount'|$route.name=='ArtistAccount'|$route.name=='ArtistPreview'" />
      <LoginButton v-show="$route.name=='Home'" />
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
