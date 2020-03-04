<template>
  <div>
    <div class="topBar">
      <Header />
      <div class="profil mx-5">
        <h2>Mon profil</h2>
        <EditIcon @onClick="customReadonly = !customReadonly; submit()" />
      </div>
    </div>

    <!-- Formulaire -->
    <form
      class="mx-5"
      :style="styleObject"
      @submit.prevent
    >
      <!-- Données de profil -->
      <FormGroup
        v-model="formArtistPhoto"
        form-group="photoInput"
        type="text"
        text="Photo de profil"
        required
        :readonly="customReadonly"
      />
      <div class="form-group">
        <label for="category">Catégorie</label>
        <select
          id="category"
          v-model="formArtistCategory"
          class="custom-form form-control"
          :disabled="customReadonly"
        >
          <option value="architecture">
            Architecture
          </option>
          <option value="sculpture">
            Sculpture
          </option>
          <option value="visual">
            Arts visuels
          </option>
          <option value="music">
            Musique
          </option>
          <option value="literature">
            Littérature
          </option>
          <option value="performing">
            Arts de la scène
          </option>
          <option value="film">
            Cinéma
          </option>
        </select>
        <div class="form-group">
          <label for="description">Description</label>
          <textarea
            id="description"
            v-model="formArtistDescription"
            class="custom-form form-control"
            rows="3"
            maxlength="230"
            placeholder="Décrivez-vous et donnez envie aux fans de vous suivre ! Maximum 230 caractères."
            :readonly="customReadonly"
          />
        </div>
      </div>

      <hr>

      <!-- Paramètrer mes flux -->
      <h2>Paramétrer mes flux</h2>

      <facebook-login
        class="facebookLogin"
        app-id="113324356787500"
        version="v5.0"
        :login-options="loginOptions"
        :login-label="loginLabel"
        :logout-label="logoutLabel"
        @sdk-loaded="sdkLoaded"
      />

      <FormGroupInline
        v-model="formYoutubeLink"
        form-group="youtubeInput"
        icon-status="youtube"
        placeholder="Votre ID de chaîne"
        :readonly="customReadonly"
      />
      <FormGroupInline
        v-model="formWordpressLink"
        form-group="wordpressInput"
        icon-status="wordpress"
        placeholder="http://www.votrenomdomaine.com/"
        :readonly="customReadonly"
      />

      <hr>

      <!-- Données de connexion -->
      <FormGroup
        v-model="formArtistEmail"
        form-group="emailInput"
        type="email"
        text="Email"
        required
        :readonly="customReadonly"
      />
      <FormGroup
        v-model="formArtistNickname"
        form-group="nicknameInput"
        type="text"
        text="Nom d'utilisateur"
        maxlength="20"
        required
        :readonly="customReadonly"
      />
    </form>

    <hr class="mx-5">

    <!-- Boutons se déconnecter et supprimer mon profil -->
    <div class="buttonGroup mx-5">
      <TextButton
        text="Me déconnecter"
        secondary
        @onClick="disconnect()"
      />
      <TextButton
        text="Supprimer mon profil"
        secondary
        @onClick="routerPush('DeleteAccount')"
      />
    </div>
  </div>
</template>

<script>
import Header from "../../components/navs/Header";
import FormGroup from "../../components/forms/FormGroup";
import EditIcon from "../../components/buttons/EditIcon";
import FormGroupInline from "../../components/forms/FormGroupInline";
import TextButton from "../../components/buttons/TextButton";
import facebookLogin from "../../components/facebook/facebook-login";

import { readonlyBus } from "../../index.js";

export default {
  name: "ArtistAccount",
  components: {
    Header,
    FormGroup,
    EditIcon,
    FormGroupInline,
    TextButton,
    facebookLogin
  },
  data() {
    return {
      styleObject: null,
      customReadonly: true,
      // Données pour le Facebook Login
      loginOptions: {
        // Ici on précise les autorisations qu'on veut demander à l'utilisateur
        scope: "public_profile, email, manage_pages"
      },
      loginLabel: "Lier la page Facebook",
      logoutLabel: "Enlever la page Facebook",
      // Données de formulaires
      formArtistPhoto: "",
      formArtistCategory: "",
      formArtistDescription: "",
      formArtistEmail: "",
      formArtistNickname: "",
      formYoutubeLink: "",
      formWordpressLink: ""
    };
  },
  computed: {
    // Récupère les infos du user dans le Store
    user() {
      return this.$store.getters["security/user"];
    }
  },
  created() {
    readonlyBus.$on("readonlyStatus", data => {
      this.customReadonly = data;
    });
  },
  mounted() {
    // Remplit les infos des formulaires avec les infos du user
    if(this.user.artist.photo) this.formArtistPhoto = this.user.artist.photo;
    else this.formArtistPhoto = "https://www.sebastienvelly.com/wp-content/themes/sebastienvelly/img/artung_logo-1.png";
    if(this.user.username) this.formArtistEmail = this.user.username;
    if(this.user.artist.nickname) this.formArtistNickname = this.user.artist.nickname;
    if(this.user.artist.category) this.formArtistCategory = this.user.artist.category;
    if(this.user.artist.description) this.formArtistDescription = this.user.artist.description;
    if(this.user.artist.youtube_link) this.formArtistYoutubeLink = this.user.artist.youtube_link;
    if(this.user.artist.wordpress_link) this.formArtistWordpressLink = this.user.artist.wordpress_link;
    // Appelle la fonction resize() une 1ère fois puis à chaque redimensionnement de fenêtre
    this.resize();
    window.addEventListener("resize", this.resize());
  },
  methods: {
    // Routes de destination des TextButton
    routerPush(name) {
      this.$router.push({ name: name });
    },
    disconnect() {
      window.location.href = window.rootUrl + "security/logout";
    },
    // Permet de changer dynamiquement le padding-top du contenu de la page en fonction de la hauteur du Header
    resize() {
      if (ResizeObserver) {
        const divTopBar = document.querySelector(".topBar");
        const resizeObserver = new ResizeObserver(entry => {
          this.styleObject = {
            paddingTop: entry[0].borderBoxSize.blockSize + "px"
          };
        });
        resizeObserver.observe(divTopBar);
      } else {
        console.log("Resize observer not supported!");
      }
    },
    sdkLoaded(payload) {
      //this.isConnected = payload.isConnected;
      this.FB = payload.FB;
    },
    async submit() {
      this.customReadonly = !this.customReadonly;
      // Update le user
      let urlUser = window.rootUrl + 'user/' + this.user.id +'/edit';
      let dataUser = {
        username: this.formArtistEmail,
        nickname: this.formArtistNickname
      };
      console.log(dataUser)
      try {
        await fetch(urlUser, {
          method: "PUT",
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json"
          },
          body: JSON.stringify(dataUser)
        });
      } catch (err) {
        console.log(err);
      }
      // Update l'artist associé
      let urlArtist = window.rootUrl + 'artists/' + this.user.artist.id +'/edit';
      let dataArtist = {
        nickname: this.formArtistNickname,
        photo: this.formArtistPhoto,
        category: this.formArtistCategory,
        description: this.formArtistDescription,
        youtube_link: this.formYoutubeLink,
        wordpress_link: this.formWordpressLink
      };
      console.log(dataArtist)
      try {
        await fetch(urlArtist, {
          method: "PUT",
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json"
          },
          body: JSON.stringify(dataArtist)
        });
      } catch (err) {
        console.log(err);
      }
    }
  }
};
</script>

<style lang="scss">
.profil {
  display: flex;
  justify-content: space-between;
}
h2 {
  font-size: 3rem;
  color: var(--light);
}
label {
  font-size: 2em;
  color: var(--light);
  font-family: "Caveat";
}
.form-control-plaintext {
  color: var(--light);
}
.form-control:disabled, .form-control[readonly] {
  background-color: var(--black);
  color: var(--light);
}
.facebookLogin {
  margin: var(--spacing-lg) 0;
}
hr {
  height: var(--spacing-xs);
  background-color: var(--dark);
  border-top: 0;
}
.buttonGroup button {
  margin-bottom: var(--spacing-md);
}
</style>
