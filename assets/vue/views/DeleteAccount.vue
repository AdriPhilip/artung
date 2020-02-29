<template>
  <div>
    <Checkbox text="Etes-vous certain de vouloir supprimer votre compte ?" />
    <TextButton
      text="Non !"
      @onClick="routerPush()"
    />
    <TextButton
      text="Si, adieu !"
      secondary
    />
  </div>
</template>

<script>
import Checkbox from '../components/forms/Checkbox'
import TextButton from '../components/buttons/TextButton'

export default {
  name: 'DeleteAccount',
  components: {
    Checkbox,
    TextButton,
  },
  computed: {
    role() {
      return this.$store.getters["security/roles"][0];
    }
  },
  methods: {
    // Routes de destination des TextButton
    routerPush() {
      if(this.role === "ROLE_FAN") this.$router.push({ name: "FanAccount" });
      else if(this.role === "ROLE_ARTIST") this.$router.push({ name: "ArtistAccount" });
      else this.$router.push({ name: "Home" });
    }
  }
};
</script>

<style lang="scss">

</style>
