<template>
  <div class="form-group">
    <label :for="formGroup">{{ text }}</label>
    <!-- La value sera à passer en props -->
    <!-- <input
      :id="formGroup"
      :value="infosArtistResults.nickname"
      :placeholder="placeholder"
      @readonlyStatus="readonlyStatus"

      Remettre le :readonly dans l'input si le watch n'est pas utilisé !!!
      :readonly="readonlyValue"      
    >-->
    <input
      :id="formGroup"
      v-model="model"
      class="form-control"
      :placeholder="placeholder"
      @input="$emit('input', model)"
    >
  </div>
</template>
<!-- Types : text, password, email -->

<script>
import { readonlyBus } from "../../index.js";
export default {
  name: 'FormGroup',
  props: {
    text: {
      type: String,
      required: true,
    },
    typeStatus: {
      type: String,
      required: true,
    },
    formGroup: {
      type: String,
      required: true,
    },
    model: {
      type: String,
      default: '',
    },
    placeholder: {
      type: String,
      default: '',
    },
    readonlyStatus: Boolean,
  },
  data() {
    return {
      infosArtistResults: null,
      readonlyValue: true
    };
  },
  computed: {
    urlArtist() {
      return `${window.rootUrl}artists/5`;
    }
  },
  watch: {
    readonlyValue: function() {
      this.$el.querySelector("input").toggleAttribute("readonly");
    }
  },

  // methods: {
  //   typeChange: function() {
  //     if (this.typeStatus == "email") {
  //       this.$el.querySelector("input").setAttribute("type", "email");
  //     } else if (this.typeStatus == "password") {
  //       this.$el.querySelector("input").setAttribute("type", "password");
  //     } else {
  //       this.$el.querySelector("input").setAttribute("type", "text");
  //     }
  //   },
  created() {
    this.getInfosArtist();
    readonlyBus.$on("readonlyStatus", data => {
      this.readonlyValue = data;
    });
  },
  mounted() {
    this.typeChange();
  },
  methods: {
    typeChange() {
      switch (this.typeStatus) {
      case 'email':
        this.$el.querySelector('input').setAttribute('type', 'email');
        break;
      case 'password':
        this.$el.querySelector('input').setAttribute('type', 'password');
        break;
      case 'text':
        this.$el.querySelector('input').setAttribute('type', 'text');
        break;
      default:
        this.$el.querySelector('input').setAttribute('type', 'text');
      }
    },

    // isReadonly() {
    //   if (this.readonlyValue == true) {
    //     this.$el.querySelector("input").toggleAttribute("readonly");
    //     this.$el.querySelector("input").classList.add("form-control-plaintext");
    //   } else {
    //     this.$el.querySelector("input").toggleAttribute("readonly");
    //     this.$el
    //       .querySelector("input")
    //       .classList.remove("form-control-plaintext");
    //   }
    // },

    async getInfosArtist() {
      try {
        const response = await fetch(this.urlArtist);
        const result = await response.json();
        this.infosArtistResults = result;
      } catch (err) {
        console.log(err);
      }
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped></style>
