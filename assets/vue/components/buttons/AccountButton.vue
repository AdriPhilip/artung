<template>
  <div>
    <button
      id="AccountButton"
      @click="$emit('onClick')"
    >
      <img
        id="AccountButtonImg"
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
      /* fan: {
        nickname: "OSS117",
        photo: "https://image.flaticon.com/icons/svg/1177/1177568.svg"
      } */
    };
  },
  computed: {
    photo() {
      if (this.accountInfo.photo == null) {
        return "https://image.flaticon.com/icons/svg/1177/1177568.svg";
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
#AccountButton {
  width: 54px;
  height: 54px;
  background-color: #131b23;
  display: flex;
  justify-content: center;
}

#AccountButtonImg {
  max-width: 54px;
  max-height: 54px;
}
</style>
