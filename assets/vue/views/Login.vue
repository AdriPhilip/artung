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
        form
        @onClick="performLogin()"
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
  },
  methods: {
    async performLogin() {
      this.$router.push({ name: "ArtistAccount", params: '' });
      // let payload = {login: this.$data.login, password: this.$data.password},
      //   redirect = this.$route.query.redirect;

      // await this.$store.dispatch("security/login", payload);
      // if (!this.$store.getters["security/hasError"]) {
      //   if (typeof redirect !== "undefined") {
      //     this.$router.push({path: redirect});
      //   } else {
      //     this.$router.push({path: "/home"});
      //   }
      // }
    }
  }
};
</script>

<style lang="scss">

</style>
