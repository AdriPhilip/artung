<template>
  <div>
    <div class="topBar">
      <Header />
      <p v-show="loading">
        Chargement des infos de l'artiste...
      </p>
      <ArtistCard
        v-show="infosArtistResults"
        :artist="infosArtistResults"
        :style="styleObject"
      />
      <SearchBar
        v-show="!loading"
        :search-types="searchTypes"
      />
    </div>
    <ListPosts
      v-show="infosArtistResults"
      :style="stylePaddingTopObject"
    />
  </div>
</template>

<script>
import Header from "../../components/navs/Header";
import ArtistCard from "../../components/artists/ArtistCard";
import SearchBar from "../../components/searchs/SearchBar";
import ListPosts from "../../components/posts/ListPosts";

export default {
  name: "ArtistDetails",
  components: {
    Header,
    ArtistCard,
    SearchBar,
    ListPosts
  },
  data() {
    return {
      infosArtistResults: null,
      searchTypes: ["flux", "date"],
      styleObject: {width: "100%"},
      stylePaddingTopObject: null,
      loading: false
    };
  },
  computed: {
    urlArtist() {
      return `${window.rootUrl}artists/${this.$route.params.id}`;
    }
  },
  created() {
    this.getInfosArtist();
  },
  mounted() {
    this.resize();
    window.addEventListener("resize", this.resize());
  },
  methods: {
    // retourne le artist JSON qui sort de l'API
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
    // Permet de changer dynamiquement le padding-top du contenu de la page en fonction de la hauteur du Header
    resize() {
      if(ResizeObserver) {
        const divTopBar = document.querySelector('.topBar');
        const resizeObserver = new ResizeObserver(entry => {
          this.stylePaddingTopObject = {paddingTop: entry[0].borderBoxSize.blockSize + 'px'}
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
p {
  color: var(--light);
}
</style>
