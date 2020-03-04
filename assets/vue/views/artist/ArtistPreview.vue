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
    <ListPosts
      :artist="artistProp"
      :style="stylePaddingTopObject"
    />
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
      styleObject: {width: "100%"},
      stylePaddingTopObject: null
    };
  },
  computed: {
    artistProp() {
      return this.$route.params.artist;
    }
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
</style>
