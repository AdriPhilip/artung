<template>
  <div class="listPosts">
    <div
      v-for="(post, generateId) of sortedListPostsArray"
      :key="generateId"
    >
      <!-- Posts Youtube -->
      <div
        v-if="post.typePost === 'youtube'"
        class="youtubePost"
      >
        <div class="headerPost">
          <font-awesome-icon
            :icon="['fab', 'youtube']"
            size="3x"
            class="icon"
            @click="changeFlux('youtube')"
          />
          <span>{{ post.date }}</span>
          <TextButton
            text="Source"
            secondary
            icon
            @onClick="openSource(post.typePost, post.id.videoId)"
          />
        </div>
        <div class="video">
          <iframe
            width="560"
            height="315"
            :src="`https://www.youtube.com/embed/${post.id.videoId}`"
            frameborder="0"
            allowfullscreen
          />
        </div>
        <hr>
      </div>
      <!-- Posts Wordpress -->
      <div
        v-if="post.typePost === 'wordpress'"
        class="wordpressPost"
      >
        <div class="headerPost">
          <font-awesome-icon
            :icon="['fab', 'wordpress']"
            size="3x"
            class="icon"
            @click="changeFlux('wordpress')"
          />
          <span>{{ post.date }}</span>
          <TextButton
            text="Source"
            secondary
            icon
            @onClick="openSource(post.typePost, post.link)"
          />
        </div>
        <h3>{{ post.title.rendered }}</h3>
        <!-- eslint-disable-next-line vue/no-v-html -->
        <p v-html="post.content.rendered" />
        <hr>
      </div>
      <!-- Posts Facebook -->
      <div
        v-if="post.typePost === 'facebook'"
        class="facebookPost"
      >
        <div class="headerPost">
          <font-awesome-icon
            :icon="['fab', 'facebook']"
            size="3x"
            class="icon"
            @click="changeFlux('facebook')"
          />
          <span>{{ post.date }}</span>
          <TextButton
            text="Source"
            secondary
          />
        </div>
        <h3>Post Facebook</h3>
        <!-- eslint-disable-next-line vue/no-v-html -->
        <p>{{ post.message }}</p>
        <img :src="post.picture">
        <hr>
      </div>
    </div>
    <p v-show="loading">
      Chargement des actualités...
    </p>
    <p v-show="!loading && listPostsArray.length === 0">
      Cet artiste n'a pas d'actualités.
    </p>
    <p
      v-show="!loading && sortedListPostsArray.length === 0 && searchFlux != ''"
    >
      Cet artiste n'a pas d'actualités sur ce réseau.
    </p>
  </div>
</template>

<script>
import TextButton from "../buttons/TextButton";
import { searchBus } from "../../index.js";

export default {
  name: "ListPosts",
  components: {
    TextButton
  },
  data() {
    return {
      infosArtistResults: null,
      wordpressResults: null,
      youtubeResults: null,
      facebookResults: null,
      listPostsArray: [],
      loading: false,
      searchDate: "",
      searchFlux: ""
    };
  },
  computed: {
    urlArtist() {
      return `${window.rootUrl}artists/${this.$route.params.id}`;
    },
    // S'assurer que l'url fournie finit par / et est une adresse Wordpress valide
    urlWordpress() {
      if (this.infosArtistResults.wordpressLink) return `${this.infosArtistResults.wordpressLink}wp-json/wp/v2/posts`;
      else return null;
    },
    urlYoutube() {
      if (this.infosArtistResults.youtubeLink) return `https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=${this.infosArtistResults.youtubeLink}&order=date&type=video&videoEmbeddable=true&videoSyndicated=true&key=${window.youtubeApi}`;
      else return null;
    },
    // urlFacebook() {
    //   // TODO A changer avec l'ID de la page de l'artiste
    //   return this.infosArtistResults.facebookLink;
    //   // Récupère la valeur après le dernier slash, i. e. l'ID de la page
    //   //return /[^/]*$/.exec(this.artist.facebookLink);
    // },
    sortedListPostsArray() {
      // Tri par date
      const sortedByDate = this.sortByDate();
      // Tri par flux
      const sortByFlux = this.sortByFlux(sortedByDate);
      return sortByFlux;
    }
  },
  watch: {
    // Surveille si l'id de la route change : charge les infos de l'artiste à chaque changement
    '$route' () {
      this.infosArtistResults=null;
      this.wordpressResults=[];
      this.youtubeResults=[];
      this.listPostsArray=[];
      this.getInfosArtist();
    }
  },
  created() {
    this.getInfosArtist();
    searchBus.$on("input-date", data => {
      this.searchDate = data;
    });
    searchBus.$on("input-flux", data => {
      this.searchFlux = data;
    });
  },
  methods: {
    // Ouvre la source dans une nouvelle fenêtre
    openSource(type, url) {
      if (type === "youtube") window.open("https://www.youtube.com/watch?v=" + url);
      else if (type === "wordpress") window.open(url);
    },
    // retourne le artist JSON qui sort de l'API
    async getInfosArtist() {
      this.loading = true;
      try {
        const response = await fetch(this.urlArtist);
        const result = await response.json();
        this.infosArtistResults = result;
        if (this.urlWordpress) this.getInfosWordpress();
        else this.loading = false;
        if (this.urlYoutube) this.getInfosYoutube();
        else this.loading = false;
        //if (this.infosArtistResults.FacebookLink !== "") this.getInfosFacebook(); else this.loading = false;
      } catch (err) {
        console.log(err);
      }
    },
    // Récupère les données de l'API de Wordpress
    async getInfosWordpress() {
      try {
        const response = await fetch(this.urlWordpress);
        const wpResult = await response.json();
        if (wpResult) {
          this.wordpressResults = wpResult;
          this.pushWordpressPosts();
        }
      } catch (err) {
        console.log(err);
      }
    },
    // Récupère les données de l'API de Youtube
    async getInfosYoutube() {
      try {
        const response = await fetch(this.urlYoutube);
        const ytResult = await response.json();
        if (!ytResult.error) {
          this.youtubeResults = ytResult.items;
          this.pushYoutubePosts();
        }
      } catch (err) {
        console.log(err);
      }
    },
    // async getInfosFacebook() {
    //   console.log("Fonction getInfosFacebook");
    //   let url = "/" + this.urlFacebook;
    //   console.log(window.appAccessToken);
    //   try {
    //     window.FB.api(
    //       url,
    //       "GET",
    //       {
    //         fields:
    //           "posts{event,picture,attachments,comments,created_time,message}"
    //       },
    //       page => {
    //         console.log(page);
    //         console.log(page.data);
    //         if (page) {
    //           this.facebookResults = page.posts.data;
    //           this.pushFacebookPosts();
    //         } else {
    //           console.log("La page Facebook n'a pas été trouvée");
    //         }
    //       }
    //     );
    //   } catch (err) {
    //     console.log(err);
    //   }
    // },
    // Pousse les données Youtube dans le tableau listPostArray, génère un "generateId", ajoute une donnée "typePost" et crée la donnée "date" à partir de "publishedAt" en prenant les 10 premiers caractères
    pushYoutubePosts() {
      let i = 0;
      this.youtubeResults.forEach(element => {
        element.generateId = i;
        element.typePost = "youtube";
        element.date = element.snippet.publishedAt.substring(0, 10);
        this.listPostsArray.push(element);
        i++;
      });
      this.loading = false;
    },
    // Pousse les données Wordpress dans le tableau listPostArray, crée un "generateId" à partir de "id", ajoute une donnée "typePost" et modifie la donnée "date" en prenant uniquement les 10 premiers caractères
    pushWordpressPosts() {
      this.wordpressResults.forEach(element => {
        element.generateId = element.id;
        element.typePost = "wordpress";
        element.date = element.date.substring(0, 10);
        this.listPostsArray.push(element);
      });
      this.loading = false;
    },
    // pushFacebookPosts() {
    //   this.facebookResults.forEach(element => {
    //     element.typePost = "facebook";
    //     element.date = element.created_time.substring(0, 10);
    //     this.listPostsArray.push(element);
    //   });
    //   this.loading = false;
    // },
    sortByDate() {
      let order = 1;
      if (this.searchDate != "") {
        order = this.searchDate == "asc" ? -1 : 1;
      }
      const sortByMapped = (map, compareFn) => (a, b) =>
        compareFn(map(a.date), map(b.date));
      const toDate = e => new Date(e).getTime();
      const byValue = (a, b) => (b - a) * order;
      const byDate = sortByMapped(toDate, byValue);
      return [...this.listPostsArray].sort(byDate);
    },
    sortByFlux(posts) {
      if (this.searchFlux != "") {
        return posts.filter(this.filterByFlux);
      } else {
        return posts;
      }
    },
    filterByFlux: function(post) {
      if (post.typePost.includes(this.searchFlux)) {
        return true;
      } else {
        return false;
      }
    },
    changeFlux(flux) {
      this.searchFlux = flux;
      searchBus.$emit("input-flux", flux);
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.listPosts {
  padding-top: 280px;
}
hr {
  height: var(--spacing-xs);
  margin-top: var(--spacing-md);
  margin-bottom: var(--spacing-sm);
  background-color: var(--dark);
  border-top: 0;
}
.headerPost {
  display: flex;
  align-items: center;
}
/* Marge gauche sur la date */
.headerPost span {
  margin-left: var(--spacing-sm);
}
/* Met le bouton "source" tout à droite */
.headerPost > div {
  margin-left: auto;
}
svg,
span,
p,
h3 {
  color: var(--light);
}
h3 {
  font-size: 3em;
}
.video {
  display: flex;
  justify-content: center;
  max-width: 100%;
}
/* >>> : sélecteur css pour sélectionner du html généré à partir du v-html de Vue */
.wordpressPost >>> img {
  display: block;
  max-width: 90%;
  margin: 0 auto;
}
.wordpressPost >>> p {
  background-color: var(--dark);
  padding: var(--spacing-sm);
}
.wordpressPost >>> p,
.wordpressPost >>> a,
.wordpressPost >>> strong {
  font-size: 1.2em;
}
@media (min-width: 768px) {
  .youtubePost,
  .wordpressPost {
    max-width: 60%;
    margin: 0 auto;
  }
}

.icon {
  cursor: pointer;
}
</style>
