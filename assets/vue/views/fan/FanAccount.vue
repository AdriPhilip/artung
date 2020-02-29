<template>
  <div>
    <Header />

    <!-- Formulaire de données de profil -->
    <form @submit.prevent>
      <EditIcon />
      <FormGroup
        form-group="photoInput"
        type-status="text"
        text="Photo de profil"
        :model="user.artist.photo"
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
      @onClick="window.location.href = '/api/security/logout'"
    />
    <TextButton
      text="Supprimer mon profil"
      secondary
      @onClick="routerPush('DeleteAccount', '')"
    />
  </div>
</template>

<script>
import Header from '../../components/navs/Header'
import FormGroup from '../../components/forms/FormGroup'
import EditIcon from '../../components/buttons/EditIcon'
import FormAccount from '../../components/forms/FormAccount'
import TextButton from '../../components/buttons/TextButton'

export default {
  name: 'FanAccount',
  components: {
    Header,
    FormGroup,
    EditIcon,
    FormAccount,
    TextButton,
  },
  computed: {
    // Récupère les infos du user dans le Store
    user() {
      return this.$store.getters["security/user"];
    }
  },
  methods: {
    // Routes de destination des TextButton
    routerPush(name, params) {
      this.$router.push({ name: name, params: params });
    }
  }
};
</script>

<style lang="scss">

</style>
