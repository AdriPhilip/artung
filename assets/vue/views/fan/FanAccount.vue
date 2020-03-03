<template>
  <div>
    <div class="topBar">
      <Header />
    </div>

    <h2 class="profil ml-5">
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
  computed: {
    // Récupère les infos du user dans le Store
    user() {
      return this.$store.getters["security/user"];
    }
  },
  methods: {
    // Routes de destination des TextButton
    routerPush(name) {
      this.$router.push({ name: name });
    },
    disconnect() {
      window.location.href = window.rootUrl + "security/logout";
    }
  }
};
</script>

<style lang="scss">
.profil {
  font-size: 3em;
  color: var(--light);
  padding-top: 102px;
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
