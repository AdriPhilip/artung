<template>
  <div>
    <div class="topBar">
      <Header />
      <SearchBar :search-types="searchTypes" />
    </div>
    <ListArtists
      :style="styleObject"
      :search-by-category="searchCategory"
      :search-by-text="searchText"
    />
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
      styleObject: null
    };
  },
  created() {
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
    }
  }
};
</script>

<style lang="scss">
</style>
