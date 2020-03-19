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
    listArtistsResults: {
      type: Array,
      required: true  
    },
    searchByCategory: {
      type: String,
      default: ""
    },
    searchByText: {
      type: String,
      default: ""
    }
  },
  computed: {
    // filtre les résultats, par texte, par catégorie, ou pas du tout
    filteredArtists: function() {
      if (this.searchByText !== "") {
        return this.listArtistsResults.filter(this.filterArtistsByText);
      } else if (this.searchByCategory !== "") {
        return this.listArtistsResults.filter(this.filterArtistsByCategory);
      } else {
        return this.listArtistsResults;
      }
    }
  },
  methods: {
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
div:nth-child(2n) {
  margin-right: 0;
}
</style>
