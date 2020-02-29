<template>
  <div>
    <form>
      <FormGroup
        form-group="emailInput"
        type-status="email"
        text="Email"
        placeholder="nom@nom-de-domaine.com"
      />
      <FormGroup
        form-group="passwordInput"
        type-status="password"
        text="Mot de passe"
      />
      <Checkbox text="Rester connecté" />
      <TextButton
        text="Go !"
        route="Catalog"
        form
      />
    </form>
  </div>
</template>

<script>
import FormGroup from '../components/forms/FormGroup'
import Checkbox from '../components/forms/Checkbox'
import TextButton from '../components/buttons/TextButton'

export default {
  name: 'Login',
  components: {
    FormGroup,
    Checkbox,
    TextButton,
  }
};
</script>

<style lang="scss">

</style>
