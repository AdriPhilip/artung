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
        form
        @onClick="route()"
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
  methods: {
    route() {
      if(this.$route.params.role === 'artist') this.$router.push({ name: "ArtistAccount", params: '' });
      else if (this.$route.params.role === 'fan') this.$router.push({ name: "Catalog", params: '' });
    }
  }
};
</script>

<style lang="scss">

</style>
