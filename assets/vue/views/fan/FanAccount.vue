<template>
  <div>
    <div class="topBar">
      <Header />
    </div>

    <h2 class="profil">
      Mon profil
    </h2>

    <!-- Formulaire de données de profil -->
    <form @submit.prevent>
      <EditIcon />
      <FormGroup
        form-group="photoInput"
        type-status="text"
        text="Photo de profil"
        :model="user.fan.photo"
      />
    </form>

    <hr>

    <!-- Formulaire de données de connexion -->
    <FormAccount />

    <hr>

    <!-- Boutons se déconnecter et supprimer mon profil -->
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
</style>
