<template>
  <div class="artistCard">
    <div
      v-if="artist"
      :id="`artist-${ artist.id }`"
    >
      <!-- On clique sur la card pour accéder à la page détails de l'artiste -->
      <div
        class="artistInfos"
        @click.self="redirect()"
      >
        <!-- Photo de miniature à laquelle on envoie l'objet artist -->
        <ArtistThumbnail :artist="artist" />
        <!-- Nom de l'artiste -->
        <h2 class="artistNickname">
          {{ artist.nickname }}
        </h2>
        <!-- Bouton de mise en favori ; ne doit s'afficher que quand on est connecté -->
        <button
          v-show="isAuthenticated && $route.name != 'ArtistPreview'"
          class="starIcon"
          @click="addFav()"
        >
          <font-awesome-icon
            :icon="favIcon"
            size="2x"
          />
        </button>
      </div>
      <!-- Description de l'artiste ; ne s'affiche que sur la page détails -->
      <div
        v-show="$route.name=='ArtistDetails'|$route.name=='ArtistPreview'"
        class="artistDescription"
      >
        <p>{{ artist.description }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import ArtistThumbnail from "./ArtistThumbnail";
import { favBus } from "../../index.js";

export default {
  name: "ArtistCard",
  components: {
    ArtistThumbnail
  },
  props: {
    artist: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      infosFavResults: null,
      fav: false,
      favIcon: ["far", "star"],
      favRequest: "addfav"
    };
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
    urlFav() {
      if(this.user) return (
        window.rootUrl + "fans/" + this.user.fan.id + "/" + this.favRequest + "/" + this.artist.id
      );
      else return "";
    },
    urlFan() {
      return `${window.rootUrl}fans/${this.user.fan.id}`;
    },
  },
  created() {
    if (this.isAuthenticated) this.checkFav();
  },
  methods: {
    redirect() {
      if(this.$route.name == 'Home') this.$router.push({ name: 'ArtistDetails', params: { id: this.artist.id, artist: this.artist }})
    },
    // Retourne le JSON des favoris du fan qui sort de l'API
    async getFavsFan() {
      try {
        const response = await fetch(this.urlFan);
        const result = await response.json();
        this.infosFavResults = result.favoris;
      } catch (err) {
        console.log(err);
      }
    },
    // Check au chargement de la page si le fan a l'artist en favori, si oui, modifie le corps de la requête et l'icone
    async checkFav() {
      try {
        const response = await fetch(this.urlFan);
        const result = await response.json();
        this.infosFavResults = result.favoris;
        for (const element of this.infosFavResults) {
          if (element.id === this.artist.id) {
            this.favIcon = ["fa", "star"];
            this.favRequest = "removefav";
            this.fav = true;
          }
          if (this.fav) return;
        }
      } catch (err) {
        console.log(err);
      }
    },
    // Au clic sur le bouton, change l'icone et la requête, et envoie la requête de mise en favori
    async addFav() {
      try {
        await fetch(this.urlFav, { method: "PUT" });
        favBus.$emit("reloadFav", this.user.fan.id);
        this.fav = !this.fav;
        if (this.fav) {
          this.favIcon = ["fa", "star"];
          this.favRequest = "removefav";
        } else {
          this.favIcon = ["far", "star"];
          this.favRequest = "addfav";
        }
      } catch (err) {
        console.log(err);
      }
    }
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
  font-size: 2rem;
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
.artistDescription p {
  color: var(--light);
}
@media (min-width: 768px) {
  .artistCard {
    width: calc(50% - var(--spacing-sm));
    margin-right: var(--spacing-md);
  }
  .artistNickname {
    font-size: 2.5rem;
  }
}
</style>
