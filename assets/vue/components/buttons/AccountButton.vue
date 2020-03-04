<template>
  <div class="accountButton">
    <button
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
    getAccountInfo() {
      {
        let user = this.$store.getters["security/user"];
        let role = this.$store.getters["security/roles"][0];
        if (role == "ROLE_FAN") {
          this.accountInfo = user.fan;
        } else if (role == "ROLE_ARTIST") {
          this.accountInfo = user.artist;
        }
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.accountButton {
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
img {
  max-width: 54px;
  max-height: 54px;
}
</style>
