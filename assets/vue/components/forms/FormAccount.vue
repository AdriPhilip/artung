<template>
  <div>
    <EditIcon />

    <!-- 1. FormGroup en v-for ou individuel ? -->

    <!--  2. Champ à utiliser ?
          :value="user.artist.email" 
          :value="user.artist.nickname"
          :value="user.artist.password" -->
    <h1>Email</h1>
    <FormGroup />
    <h1>Nom d'utilisateur</h1>
    <FormGroup />
    <h1>Mot de passe</h1>
    <FormGroup type="password">
      <FormGroupInline />
    </FormGroup>
  </div>
</template>

<script>
import FormGroup from "./FormGroup";
import FormGroupInline from "./FormGroupInline";
import EditIcon from "../buttons/EditIcon";

export default {
  name: "FormAccount",
  components: {
    FormGroup,
    FormGroupInline,
    EditIcon
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1 {
color: #f3eff5
}
</style>

