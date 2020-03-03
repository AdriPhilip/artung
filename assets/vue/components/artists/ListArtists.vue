<template>
  <div>
    <div class="listArtists">
      <!-- Boucle sur tous les artistes issus de la recherche ou du tri -->
      <ArtistCard
        v-for="(artist, id) of filteredArtists"
        :key="id"
        :artist="artist"
      />
    </div>
    <!-- Si la recherche retourne aucun artiste -->
    <p
      v-show="filteredArtists && filteredArtists.length == 0"
    >
      Aucun artiste ne correspond à votre recherche.
    </p>
    <p v-if="loading">
      Chargement des artistes...
    </p>
  </div>
</template>

<script>
import ArtistCard from "./ArtistCard";

export default {
  name: "ListArtists",
  components: {
    ArtistCard
  },
  props: {
    searchByCategory: {
      type: String,
      default: ""
    },
    searchByText: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      infosArtistResults: null,
      loading: false
    };
  },
  computed: {
    urlArtist() {
      // Url de l'API
      return `${window.rootUrl}artists`;
    },
    // filtre les résultats, par texte, par catégorie, ou pas du tout
    filteredArtists: function() {
      if (this.loading == false) {
        if (this.searchByText !== "") {
          return this.infosArtistResults.filter(this.filterArtistsByText);
        } else if (this.searchByCategory !== "") {
          return this.infosArtistResults.filter(this.filterArtistsByCategory);
        } else {
          return this.infosArtistResults;
        }
      } else {
        return null;
      }
    }
  },
  created() {
    this.getInfosArtist();
  },
  methods: {
    // retourne le JSON qui sort de l'API
    async getInfosArtist() {
      this.loading = true;
      try {
        const response = await fetch(this.urlArtist);
        const result = await response.json();
        this.infosArtistResults = result;
        this.loading = false;
      } catch (err) {
        console.log(err);
      }
    },
    // recherche par texte : compare le contenu de l'input au nickname de l'artiste, en mettant tout en minuscules
    filterArtistsByText: function(obj) {
      if (
        obj.nickname.toLowerCase().includes(this.searchByText.toLowerCase())
      ) {
        return true;
      } else {
        return false;
      }
    },
    // recherche par catégorie : compare la value du select à la catégorie de l'artiste
    filterArtistsByCategory: function(obj) {
      if (obj.category === this.searchByCategory) {
        return true;
      } else {
        return false;
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.listArtists {
  padding-top: 142px;
}
div:nth-child(2n) {
  margin-right: 0;
}
</style>
