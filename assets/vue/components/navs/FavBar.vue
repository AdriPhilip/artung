<template>
  <div class="favBar">
    <div
      v-for="(fav, id) of favs"
      :key="id"
    >
      <ArtistThumbnail
        :artist="fav"
      />
    </div>
    <p v-show="loading">
      Chargement des favoris...
    </p>
    <p v-show="!loading && favs.length === 0">
      Vous n'avez pas encore d'artistes favoris
    </p>
  </div>
</template>

<script>
import ArtistThumbnail from '../artists/ArtistThumbnail';
import { favBus } from "../../index.js";

export default {
  name: 'FavBar',
  components: {
    ArtistThumbnail,
  },
  data() {
    return {
      favs: [],
      loading: false
    }
  },
  computed: {
    // Récupère si le user est connecté
    isAuthenticated() {
      return this.$store.getters["security/isAuthenticated"];
    },
    // Récupère le user
    user() {
      if (this.isAuthenticated) return this.$store.getters["security/user"];
      else return null;
    },
    urlFan() {
      return `${window.rootUrl}fans/${this.user.fan.id}/favoris`;
    },
  },
  mounted() {
    // Au chargement le tableau de favoris est chargé
    this.getFanFavs(this.urlFan);
    //Bus d'événement pour la mise à jour des favoris
    favBus.$on("reloadFav", data => {
      let urlFanReload = `${window.rootUrl}fans/${data}/favoris`
      this.getFanFavs(urlFanReload);
    });
  },
  methods: {
    // retourne les favoris JSON qui sortent de l'API
    async getFanFavs(url) {
      this.loading = true;
      try {
        const response = await fetch(url);
        const result = await response.json();
        this.favs = result;
        this.loading = false;
      } catch (err) {
        console.log(err);
      }
    },
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.favBar {
  display: flex;
  align-items: center;
  overflow-x: auto;
  min-height: 56px;
  max-height: 76px;
  padding: 0 var(--spacing-md);
  margin: var(--spacing-md) auto var(--spacing-md) var(--spacing-md);
  border-left: var(--spacing-xs) solid var(--light);
  border-right: var(--spacing-xs) solid var(--light);
}
.favBar div {
  margin-right: var(--spacing-sm);
}
.favBar div:last-of-type {
  margin-right: 0;
}
.favBar p {
  margin-bottom: 0;
  font-size: 12px;
  color: var(--light);
}
@media (min-width: 768px) {
  .favBar p {
    font-size: 14px;
  }
}
</style>
