<template>
  <div>
    <div class="topBar">
      <Header />
      <ArtistCard
        :artist="artistProp"
        :style="styleObject"
      />
      <SearchBar :search-types="searchTypes" />
    </div>
    <ListPosts :artist="artistProp" />
  </div>
</template>

<script>
import Header from '../../components/navs/Header'
import ArtistCard from '../../components/artists/ArtistCard'
import SearchBar from '../../components/searchs/SearchBar'
import ListPosts from '../../components/posts/ListPosts'

export default {
  name: 'ArtistPreview',
  components: {
    Header,
    ArtistCard,
    SearchBar,
    ListPosts,
  },
  data() {
    return {
      searchTypes: ["flux", "date"],
      styleObject: {width: "100%"}
    };
  },
  computed: {
    artistProp() {
      return this.$route.params.artist;
    }
  }
};
</script>

<style lang="scss">
</style>
