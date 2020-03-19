<template>
  <div>
    <div class="topBar">
      <Header />
      <SearchBar :search-types="searchTypes" />
    </div>
    <ListArtists
      :list-artists-results="listArtistsResults"
      :style="styleObject"
      :search-by-category="searchCategory"
      :search-by-text="searchText"
    />
    <p v-if="loading">
      Chargement des artistes...
    </p>
  </div>
</template>

<script>
import Header from "../components/navs/Header";
import SearchBar from "../components/searchs/SearchBar";
import { searchBus } from "../index.js";
import ListArtists from "../components/artists/ListArtists";

export default {
  name: "Home",
  components: {
    Header,
    SearchBar,
    ListArtists
  },
  data() {
    return {
      searchTypes: ["category", "text"],
      searchText: "",
      searchCategory: "",
      styleObject: null,
      listArtistsResults: null,
      loading: false
    };
  },
  computed: {
    // Url d'interrogation de l'API
    urlListArtists() {
      return `${window.rootUrl}artists`;
    }
  },
  created() {
    this.getListArtists();
    // Bus d'événements pour les champs de recherche
    searchBus.$on("input-text", data => {
      this.searchText = data;
    });
    searchBus.$on("input-category", data => {
      this.searchCategory = data;
    });
  },
  mounted() {
    this.resize();
    window.addEventListener("resize", this.resize());
  },
  methods: {
    // Permet de changer dynamiquement le padding-top du contenu de la page en fonction de la hauteur du Header
    resize() {
      if(ResizeObserver) {
        const divTopBar = document.querySelector('.topBar');
        const resizeObserver = new ResizeObserver(entry => {
          this.styleObject = {paddingTop: entry[0].borderBoxSize.blockSize + 'px'}
        });
        resizeObserver.observe(divTopBar);
      } else {
        console.log('Resize observer not supported!');
      }
    },
    // Retourne le JSON de la liste des artistes qui sort de l'API
    async getListArtists() {
      this.loading = true;
      try {
        const response = await fetch(this.urlListArtists);
        const result = await response.json();
        this.listArtistsResults = result;
        this.loading = false;
      } catch (err) {
        console.log(err);
      }
    }
  }
};
</script>

<style lang="scss">
</style>
