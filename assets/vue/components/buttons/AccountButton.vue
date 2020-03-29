<template>
  <div class="accountButton">
    <button
      title="Mon profil"
      @click="$emit('onClick')"
    >
      <img
        :src="photo"
        :alt="`photo de profil de ${ accountInfo.nickname }`"
      >
    </button>
  </div>
</template>

<script>
export default {
  name: "AccountButton",
  data() {
    return {
      accountInfo: ""
    };
  },
  computed: {
    photo() {
      if (this.accountInfo.photo == null) {
        return "https://www.sebastienvelly.com/wp-content/themes/sebastienvelly/img/artung_logo-1.png";
      } else {
        return this.accountInfo.photo;
      }
    }
  },
  created() {
    this.getAccountInfo();
  },
  methods: {
    async getAccountInfo() {
      {
        let user = this.$store.getters["security/user"];
        let role = this.$store.getters["security/roles"][0];
        if (role == "ROLE_FAN") {
          // retourne le fan JSON qui sort de l'API
          try {
            const response = await fetch(`${window.rootUrl}fans/${user.fan.id}`);
            const result = await response.json();
            this.accountInfo = result;
          } catch (err) {
            console.log(err);
          }
        } else if (role == "ROLE_ARTIST") {
          // retourne le artist JSON qui sort de l'API
          try {
            const response = await fetch(`${window.rootUrl}artists/${user.artist.id}`);
            const result = await response.json();
            this.accountInfo = result;
            this.loading = false;
          } catch (err) {
            console.log(err);
          }
        }
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.accountButton {
  min-width: 54px;
  min-height: 54px;
  border: var(--spacing-xs) solid var(--primary);
  border-radius: 50%;
  overflow:hidden;
}
button {
  width: 54px;
  height: 54px;
  background-color: transparent;
  border: 0;
  display: flex;
  justify-content: center;
}
</style>
