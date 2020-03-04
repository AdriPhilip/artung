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
      <EditIcon />
      <FormGroup
        form-group="photoInput"
        type-status="text"
        text="Photo de profil"
        :model="user.fan.photo"
        readonly
      />
    </form>

    <hr class="mx-5">

    <!-- Formulaire de données de connexion -->
    <FormAccount />

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
import FormAccount from "../../components/forms/FormAccount";
import TextButton from "../../components/buttons/TextButton";

export default {
  name: "FanAccount",
  components: {
    Header,
    FormGroup,
    EditIcon,
    FormAccount,
    TextButton
  },
  data() {
    return {
      styleObject: null
    }
  },
  computed: {
    // Récupère les infos du user dans le Store
    user() {
      return this.$store.getters["security/user"];
    }
  },
  mounted() {
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
