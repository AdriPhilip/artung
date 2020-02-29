<template>
  <div>
    <form class="m-5 p-5">
      <FormGroup
        form-group="emailInput"
        type-status="email"
        text="Email"
        placeholder="nom@nom-de-domaine.com"
      />
      <FormGroup
        form-group="nicknameInput"
        type-status="text"
        text="Nom d'utilisateur"
      />
      <FormGroup
        form-group="passwordInput"
        type-status="password"
        text="Mot de passe"
      />
      <FormGroup
        form-group="confirmPasswordInput"
        type-status="password"
        text="Confirmer le mot de passe"
      />
      <TextButton
        text="Go !"
        :route="route"
        form
      />
    </form>
  </div>
</template>

<script>
import FormGroup from '../components/forms/FormGroup'
import TextButton from '../components/buttons/TextButton'

export default {
  name: 'Register',
  components: {
    FormGroup,
    TextButton,
  },
  computed: {
    route() {
      if(this.$route.params.params.role === 'artist') return 'ArtistAccount';
      else return 'Catalog';
    }
  }
};
</script>

<style lang="scss">

</style>
