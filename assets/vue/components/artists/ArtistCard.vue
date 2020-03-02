<template>
  <div
    :id="`artist-${ artist.id }`"
    class="artistCard"
  >
    <!-- On clique sur la card pour accéder à la page détails de l'artiste -->
    <div
      class="artistInfos"
      @click.self="$router.push({ name: 'ArtistDetails', params: { id: artist.id, artist: artist }})"
    >
      <!-- Photo de miniature à laquelle on envoie l'objet artist -->
      <ArtistThumbnail :artist="artist" />
      <!-- Nom de l'artiste -->
      <h2 class="artistNickname">
        {{ artist.nickname }}
      </h2>
      <!-- Bouton de mise en favori ; ne doit s'afficher que quand on est connecté -->
      <button
        v-if="isAuthenticated"
        class="starIcon"
      >
        <font-awesome-icon
          :icon="['far', 'star']"
          size="2x"
        />
      </button>
    </div>
    <!-- Description de l'artiste ; ne s'affiche que sur la page détails -->
    <div
      v-show="$route.name=='ArtistDetails'|$route.name=='ArtistPreview'"
      class="artistDescription"
    >
      <p>
        {{ artist.description }}
      </p>
    </div>
  </div>
</template>

<script>
import ArtistThumbnail from './ArtistThumbnail'

export default {
  name: 'ArtistCard',
  components: {
    ArtistThumbnail,
  },
  props: {
    artist: {
      type: Object,
      default: null
    }
  },
  computed: {
    // Récupère si le user est connecté
    isAuthenticated() {
      return this.$store.getters["security/isAuthenticated"]
    },
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .artistCard {
    display: inline-block;
    width: 100%;
    min-height: 60px;
    max-height: 240px;
    margin-bottom: var(--spacing-md);
    padding-left: var(--spacing-xs);
    background-color: var(--dark);
    border-radius: 0 var(--spacing-sm) var(--spacing-sm) var(--spacing-sm);
    cursor: pointer;
    transition: background-color 400ms;
  }
  .artistCard:hover {
    background-color: var(--light-transparent);
  }
  .artistInfos {
    position: relative;
    padding-top: var(--spacing-xs);
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
  }
  .artistNickname {
    font-size: 2.5em;
    color: var(--light);
    margin-left: var(--spacing-sm);
  }
  .starIcon {
    position: absolute;
    top: var(--spacing-xs);
    right: var(--spacing-xs);
    background-color: transparent;
    color: var(--primary);
    border: 0;
    padding: 0;
    margin-left: auto;
    margin-bottom: auto;
  }
  .artistDescription {
    padding: var(--spacing-xs);
  }
  @media (min-width: 768px) {
    .artistCard {
      width: calc(50% - var(--spacing-md) / 2);
      margin-right: var(--spacing-md);
    }
    .artistNickname {
      font-size: 3.25em;
    }
  }
</style>
