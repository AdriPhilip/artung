<template>
  <div class="listPosts">
    <div
      v-for="(post, generateId) of sortedListPostsArray"
      :key="generateId"
    >
      <!-- Posts Youtube -->
      <div
        v-if="post.typePost==='youtube'"
        class="youtubePost"
      >
        <div class="headerPost">
          <font-awesome-icon
            :icon="['fab', 'youtube']"
            size="3x"
          />
          <span>{{ post.date }}</span>
          <TextButton
            text="Source"
            secondary
          />
        </div>
        <div class="video">
          <iframe
            width="560"
            height="315"
            :src="`https://www.youtube.com/embed/${post.id.videoId}`"
            frameborder="0"
            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
          />
        </div>
        <hr>
      </div>
      <!-- Posts Wordpress -->
      <div
        v-if="post.typePost==='wordpress'"
        class="wordpressPost"
      >
        <div class="headerPost">
          <font-awesome-icon
            :icon="['fab', 'wordpress']"
            size="3x"
          />
          <span>{{ post.date }}</span>
          <TextButton
            text="Source"
            secondary
          />
        </div>
        <h3>{{ post.title.rendered }}</h3>
        <!-- eslint-disable-next-line vue/no-v-html -->
        <p v-html="post.content.rendered" />
        <hr>
      </div>
    </div>
    <p v-show="listPostsArray.length == 0">
      Cet artiste n'a pas d'actualités.
    </p>
  </div>
</template>

<script>
import TextButton from '../buttons/TextButton'

export default {
  name: 'ListPosts',
  components: {
    TextButton
  },
  props: {
    artist: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      wordpressResults: null,
      youtubeResults: null,
      listPostsArray: []
    }
  },
  computed: {
    // S'assurer que l'url fournie finit par / et est une adresse Wordpress valide
    urlWordpress() {
      return `${this.artist.wordpressLink}wp-json/wp/v2/posts`;
    },
    urlYoutube() {
      return `https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=${this.artist.youtubeLink}&order=date&type=video&videoEmbeddable=true&videoSyndicated=true&key=${window.youtubeApi}`;
    },
    // Trie les posts par ordre antéchronologique
    sortedListPostsArray() {
      const sortByMapped = (map,compareFn) => (a,b) => compareFn(map(a.date),map(b.date));
      const toDate = e => new Date(e).getTime();
      const byValue = (a,b) => b - a;
      const byDate = sortByMapped(toDate,byValue);
      return [...this.listPostsArray].sort(byDate);
    }
  },
  created() {
    this.getInfosWordpress();
    this.getInfosYoutube();
  },
  methods: {
    // Récupère les données de l'API de Wordpress
    async getInfosWordpress() {
      try {
        const response = await fetch(this.urlWordpress);
        const wpResult = await response.json();
        this.wordpressResults = wpResult;
        this.pushWordpressPosts();
      } catch (err) {
        console.log(err);
      }
    },
    // Récupère les données de l'API de Youtube
    async getInfosYoutube() {
      try {
        const response = await fetch(this.urlYoutube);
        const ytResult = await response.json();
        this.youtubeResults = ytResult.items;
        this.pushYoutubePosts();
      } catch (err) {
        console.log(err);
      }
    },
    // Pousse les données Youtube dans le tableau listPostArray, génère un "generateId", ajoute une donnée "typePost" et crée la donnée "date" à partir de "publishedAt" en prenant les 10 premiers caractères
    pushYoutubePosts() {
      let i=0;
      this.youtubeResults.forEach(element => {
        element.generateId=i;
        element.typePost="youtube";
        element.date=element.snippet.publishedAt.substring(0,10);
        this.listPostsArray.push(element);
        i++;
      });
    },
    // Pousse les données Wordpress dans le tableau listPostArray, crée un "generateId" à partir de "id", ajoute une donnée "typePost" et modifie la donnée "date" en prenant uniquement les 10 premiers caractères
    pushWordpressPosts() {
      this.wordpressResults.forEach(element => {
        element.generateId=element.id;
        element.typePost="wordpress";
        element.date=element.date.substring(0,10);
        this.listPostsArray.push(element);
      })
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.listPosts {
  padding-top: 220px;
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
svg, span, p, h3 {
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
.wordpressPost >>> p, .wordpressPost >>> a, .wordpressPost >>> strong {
  font-size: 1.2em;
}
@media (min-width: 768px) {
  .youtubePost, .wordpressPost {
    max-width: 60%;
    margin: 0 auto;
  }
}
</style>
