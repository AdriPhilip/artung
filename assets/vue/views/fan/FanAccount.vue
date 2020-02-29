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
      @onClick="routerPush('Home', '')"
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
  }
};
</script>

<style lang="scss">

</style>
