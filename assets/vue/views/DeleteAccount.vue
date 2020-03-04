<template>
  <div>
    <form
      class="mx-5"
      @submit.prevent
    >
      <h2 class="text-center pt-5">
        Etes-vous certain de vouloir supprimer votre compte ?
      </h2>
      <div class="d-flex justify-content-around m-5">
        <TextButton
          text="Non !"
          @onClick="routerPush()"
        />
        <TextButton
          text="Si, adieu !"
          secondary
          @onClick="deleteAccount()"
        />
      </div>
    </form>
  </div>
</template>

<script>
import TextButton from '../components/buttons/TextButton'

export default {
  name: 'DeleteAccount',
  components: {
    TextButton,
  },
  computed: {
    // Récupère les infos du user dans le Store
    user() {
      return this.$store.getters["security/user"];
    },
    // récupère le rôle du user connecté
    role() {
      return this.$store.getters["security/roles"][0];
    }
  },
  methods: {
    // Routes de destination des TextButton en fonction du rôle
    routerPush() {
      if(this.role === "ROLE_FAN") this.$router.push({ name: "FanAccount" });
      else if(this.role === "ROLE_ARTIST") this.$router.push({ name: "ArtistAccount" });
      else this.$router.push({ name: "Home" });
    },
    // Suppression de l'utilisateur
    async deleteAccount() {
      let urlUser = window.rootUrl + 'user/' + this.user.id;
      try {
        await fetch(urlUser, { method: "DELETE" });
      } catch (err) {
        console.log(err);
      }
      window.location.href = window.rootUrl + "security/logout";
    }
  }
};
</script>

<style lang="scss">
</style>
