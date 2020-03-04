<template>
  <div>
    <div class="topBar">
      <Header />
    </div>

    <div
      class="profil mx-5"
      :style="styleObject"
    >
      <h2>Mon profil</h2>
      <EditIcon @onClick="submit()" />
    </div>

    <!-- Formulaire -->
    <form
      class="mx-5"
      @submit.prevent
    >
      <!-- Données de profil -->
      <FormGroup
        v-model="formFanPhoto"
        form-group="photoInput"
        type="text"
        text="Photo de profil"
        required
        readonly
      />

      <hr>

      <!-- Données de connexion -->
      <FormGroup
        v-model="formFanEmail"
        form-group="emailInput"
        type="email"
        text="Email"
        required
        readonly
      />

      <FormGroup
        v-model="formFanNickname"
        form-group="nicknameInput"
        type="text"
        text="Nom d'utilisateur"
        maxlength="20"
        required
        readonly
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
      // Données de formulaires
      formFanPhoto: "",
      formFanEmail: "",
      formFanNickname: ""
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
    this.formFanEmail = this.user.username;
    this.formFanNickname = this.user.fan.nickname;
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
      let urlUser = window.rootUrl + 'user/' + this.user.id +'/edit';
      let dataUser = {
        username: this.formFanEmail,
        nickname: this.formFanNickname
      };
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
      // Update le fan associé
      let urlFan = window.rootUrl + 'fans/' + this.user.fan.id +'/edit';
      let dataFan = {
        nickname: this.formFanNickname,
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
  display: flex;
  justify-content: space-between;
  align-items: center;
}
h2 {
  font-size: 3rem;
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
