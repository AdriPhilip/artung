<template>
  <div>
    <div class="topBar">
      <Header />
    </div>

    <h2
      class="profil ml-5"
      :style="styleObject"
    >
      Mon profil
    </h2>

    <!-- Formulaire de données de profil -->
    <form
      class="mx-5 px-5"
      @submit.prevent
    >
      <EditIcon @onClick="submit()" />
      <FormGroup
        v-model="formFanPhoto"
        form-group="photoInput"
        type="text"
        text="Photo de profil"
        required
        readonly
      />
    </form>

    <hr class="mx-5">

    <!-- Formulaire de données de connexion -->


    <hr class="mx-5">

    <!-- Boutons se déconnecter et supprimer mon profil -->
    <div class="buttonGroup mx-5 px-5">
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
import TextButton from "../../components/buttons/TextButton";

export default {
  name: "FanAccount",
  components: {
    Header,
    FormGroup,
    EditIcon,
    TextButton
  },
  data() {
    return {
      styleObject: null,
      formFanPhoto: ""
    }
  },
  computed: {
    // Récupère les infos du user dans le Store
    user() {
      return this.$store.getters["security/user"];
    }
  },
  mounted() {
    // Remplit les infos des formulaires avec les infos du user
    if(this.user.fan.photo) this.formFanPhoto = this.user.fan.photo;
    else this.formFanPhoto = "https://www.sebastienvelly.com/wp-content/themes/sebastienvelly/img/artung_logo-1.png";
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
    async submit() {
      // Update le user
      let urlUser = window.rootUrl + '/' + this.user.id +'/edit';
      let dataUser = {
        username: this.user.login,
        nickname: this.user.fan.nickname
      };
      try {
        await fetch(urlUser, {
          method: "POST",
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json"
          },
          body: JSON.stringify(dataUser)
        });
      } catch (err) {
        console.log(err);
      }
      // Update le fan associé
      let urlFan = window.rootUrl + 'fans/' + this.user.fan.id +'/edit';
      let dataFan = {
        nickname: this.user.fan.nickname,
        photo: this.formFanPhoto
      };
      try {
        await fetch(urlFan, {
          method: "PUT",
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json"
          },
          body: JSON.stringify(dataFan)
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
  font-size: 3em;
  color: var(--light);
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
