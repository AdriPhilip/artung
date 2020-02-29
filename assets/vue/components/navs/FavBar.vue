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
    <p v-show="!favs">
      Vous n'avez pas encore d'artistes favoris
    </p>
  </div>
</template>

<script>
import ArtistThumbnail from '../artists/ArtistThumbnail'

export default {
  name: 'FavBar',
  components: {
    ArtistThumbnail,
  },
  computed: {
    // Récupère les favoris du user dans le Store
    favs() {
      return this.$store.getters["security/user"].fan.favoris;
    }
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
  margin-left: var(--spacing-md);
  margin-right: auto;
  padding: 0 var(--spacing-md);
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
