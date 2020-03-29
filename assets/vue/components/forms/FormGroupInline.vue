<template>
  <div class="form-group row">
    <label
      class="col-3 col-sm-2 col-md-1 col-form-label"
      :for="formGroup"
    >
      <font-awesome-icon
        :icon="logoReseauSocial"
        size="2x"
      />
      
    </label>
    <input
      :id="formGroup"
      v-model="value"
      type="text"
      class="col-9 col-sm-10 col-md-11 form-control"
      :placeholder="placeholder"
      autocomplete="off"
      :readonly="readonly"
      @change="$emit('change', value)"
    >
  </div>
</template>

<script>
/* eslint-disable no-unreachable */

import { vSwitch, vCase, vDefault } from "v-switch-case";
import { readonlyBus } from "../../index.js";

export default {
  name: "FormGroupInline",
  directives: {
    switch: vSwitch,
    case: vCase,
    default: vDefault
  },
  model: {
    prop: 'value',
    event: 'change'
  },
  props: {
    formGroup: {
      type: String,
      required: true
    },
    iconStatus: {
      type: String,
      required: true
    },
    value: {
      type: String,
      default: ""
    },
    placeholder: {
      type: String,
      default: ""
    },
    readonly: Boolean
  },
  computed: {
    logoReseauSocial() {
      switch (this.iconStatus) {
      case "facebook":
        return ['fab', 'facebook'];
        break;
      case "twitter":
        return ['fab', 'twitter'];
        break;
      case "youtube":
        return ['fab', 'youtube'];
        break;
      case "wordpress":
        return ['fab', 'wordpress'];
        break;
      default:
        return "question";
      }
    }
  },
  mounted() {
    this.iconChange();
    this.addFormControlPlaintext();
  },
  updated() {
    this.addFormControlPlaintext();
  },
  created() {
    readonlyBus.$on("readonlyStatus", data => {
      this.readonly = data;
    });
  },
  methods: {
    iconChange: function() {
      switch (this.iconStatus) {
      case "facebook":
        this.$el
          .querySelector("input")
          .setAttribute(
            "pattern",
            "(?:(?:http|https)://)?(?:www.)?facebook.com/(?:(?:w)*#!/)?(?:pages/)?([w-]*)?"
          );
        // Regex initial avant erreur compil escape chars : (?:(?:http|https):\/\/)?(?:www.)?facebook.com\/(?:(?:\w)*#!\/)?(?:pages\/)?([\w\-]*)?
        break;
      case "twitter":
        this.$el
          .querySelector("input")
          .setAttribute(
            "pattern",
            "http(?:s)?://(?:www.)?twitter.com/([a-zA-Z0-9_]+)"
          );
        // Regex initial avant erreur compil escape chars : /http(?:s)?:\/\/(?:www\.)?twitter\.com\/([a-zA-Z0-9_]+)/
        break;
      // case "youtube":
      //   this.$el
      //     .querySelector("input")
      //     .setAttribute(
      //       "pattern",
      //       "http(?:s?)://(?:www.)?youtu(?:be.com/watch?v=|.be/)([w-_]*)(&(amp;)?[w?=]*)?"
      //     );
      //   // Regex initial avant erreur compil escape chars : http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?[\w\?=]*)?
      //   break;
      case "wordpress":
        this.$el
          .querySelector("input")
          .setAttribute("pattern", "^https?://.*/$");
        // Regex initial avant erreur compil escape chars : ^https?:\/\/.*\/$
        break;
      default:
        this.$el.querySelector("input").setAttribute("pattern", "");
      }
    },
    addFormControlPlaintext: function() {
      if (this.readonly) {
        this.$el.querySelector("input").classList.remove("form-control");
        this.$el.querySelector("input").classList.add("form-control-plaintext");
      } else {
        this.$el.querySelector("input").classList.add("form-control");
        this.$el
          .querySelector("input")
          .classList.remove("form-control-plaintext");
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
svg {
  color: var(--light);
  /*font-size: 150%;*/
}
.formGroupInlineCss {
  font-size: 2em;
  color: var(--light);
  font-family: "Caveat";
}
.form-control-plaintext {
  color: var(--light);
}
</style>
