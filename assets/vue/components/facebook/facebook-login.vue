/* eslint-disable indent */
<template>
  <div class="container">
    <button @click="buttonClicked">
      <div
        v-if="isWorking"
        class="spinner"
      />
      <img
        v-if="!isWorking"
        :src="icon"
      > {{ getButtonText }}
    </button>
  </div>
</template>
<script>
import {loadFbSdk, getLoginStatus, fbLogout, fbLogin} from './helpers.js';
import icon from './icon.png';
export default {
  name: 'FacebookLogin',
  props: {
    appId: {
      type: String,
      required: true,
    },
    version: {
      type: String,
      default: 'v2.10',
    },
    logoutLabel: {
      type: String,
      default: 'Log out from Facebook',
    },
    loginLabel: {
      type: String,
      default: 'Log In To Facebook',
    },
    loginOptions: {
      type: Object,
      default: function() {
        return {
          scope: 'email',
        };
      },
    },
  },
  data() {
    return {
      isWorking: false,
      isConnected: false,
      icon,
    };
  },
  computed: {
    getButtonText() {
      switch (this.isConnected) {
      case true:
        return this.logoutLabel;
      case false:
        return this.loginLabel;
      default:
        return 'this is default';
      }
    },
  },
  mounted() {
    this.isWorking = true;
    loadFbSdk(this.appId, this.version)
      .then(loadingResult => {
        console.log(loadingResult);
      })
      .then(() => getLoginStatus())
      .then(response => {
        if (response.status === 'connected') {
          this.isConnected = true;
        }
        this.isWorking = false;
        /** get-initial-status to be depcreated on next major version */
        this.$emit('get-initial-status', response);
        this.$emit('sdk-loaded', {
          isConnected: this.isConnected,
          FB: window.FB,
        });
      });
  },
  methods: {
    buttonClicked() {
      this.$emit('click');
      if (this.isConnected) {
        this.logout();
      } else {
        this.login();
      }
    },
    logout() {
      this.isWorking = true;
      fbLogout().then(response => {
        this.isWorking = false;
        this.isConnected = false;
        this.$emit('logout', response);
      });
    },
    login() {
      this.isWorking = true;
      fbLogin(this.loginOptions).then(response => {
        if (response.status === 'connected') {
          this.isConnected = true;
        } else {
          this.isConnected = false;
        }
        this.isWorking = false;
        this.$emit('login', {
          response,
          FB: window.FB,
        });
      });
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
button {
  position: relative;
  padding: 0 15px 0px 46px;
  border: none;
  line-height: 34px;
  font-size: 16px;
  color: #fff;
  min-width: 225px;
  background-image: linear-gradient(#4c69ba, #3b55a0);
}

.spinner {
  box-sizing: border-box;
  width: 30px;
  height: 90%;
  border-radius: 50%;
  border: 5px solid #f3f3f3;
  border-top: 5px solid #3498db;
  animation: spin 2s linear infinite;
  position: absolute;
  left: 5px;
}

img {
  position: absolute;
  top: 3px;
  left: 10px;
  width: 30px;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
