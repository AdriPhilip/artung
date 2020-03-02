<template>
  <div>
    <div class="topBar">
      <Header />
      <ArtistCard
        :artist="artist"
        :style="styleObject"
      />
      <SearchBar :search-types="searchTypes" />
    </div>
    <ListPosts :artist="artist" />
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
      styleObject: {width: "100%"}
    };
  },
  computed: {
    urlArtist() {
      return `${window.rootUrl}artists/${this.$route.params.id}`;
    },
    artist() {
      if(this.$route.params.artist) return this.$route.params.artist;
      else return this.infosArtistResults;
    }
  },
  created() {
    if(!this.artist) this.getInfosArtist();
  },
  methods: {
    // retourne le artist JSON qui sort de l'API
    async getInfosArtist() {
      try {
        const response = await fetch(this.urlArtist);
        const result = await response.json();
        this.infosArtistResults = result;
      } catch (err) {
        console.log(err);
      }
    }
  }
};
</script>

<style lang="scss">
</style>
