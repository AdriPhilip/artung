<template>
  <div class="form-group">
    <label
      :for="formGroupInline"
      class="formGroupInlineCss"
    >{{ text }}</label>
    <span v-switch="iconStatus">
      <span v-case="'facebook'">
        <font-awesome-icon
          :icon="['fab', 'facebook']"
          size="2x"
        />
      </span>
      <span v-case="'twitter'">
        <font-awesome-icon
          :icon="['fab', 'twitter']"
          size="2x"
        />
      </span>
      <span v-case="'youtube'">
        <font-awesome-icon
          :icon="['fab', 'youtube']"
          size="2x"
        />
      </span>
      <span v-case="'wordpress'">
        <font-awesome-icon
          :icon="['fab', 'wordpress']"
          size="2x"
        />
      </span>
      <span v-default>
        <font-awesome-icon
          icon="question"
          size="2x"
        />
      </span>
    </span>
    &nbsp;
    <input
      :id="formGroupInline"
      v-model="model"
      class="form-control"
      :placeholder="placeholder"
      :readonly="readonly"
      @input="$emit('input', model)"
    >
  </div>
</template>

<script>
import { vSwitch, vCase, vDefault } from "v-switch-case";
import { readonlyBus } from "../../index.js";

export default {
  name: "FormGroupInline",
  directives: {
    switch: vSwitch,
    case: vCase,
    default: vDefault
  },
  props: {
    text: {
      type: String,
      default: ""
    },
    iconStatus: {
      type: String,
      required: true
    },
    model: {
      type: String,
      default: ""
    },
    placeholder: {
      type: String,
      default: ""
    },
    readonly: Boolean,
    readonlyStatus: Boolean
  },
  data() {
    return {
      readonlyValue: true
    };
  },
  watch: {
    readonlyValue: function() {
      this.$el.querySelector("input").toggleAttribute("readonly");
    }
  },
  created() {
    readonlyBus.$on("readonlyStatus", data => {
      this.readonlyValue = data;
    });
  },
  mounted() {
    this.iconChange();
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
      case "youtube":
        this.$el
          .querySelector("input")
          .setAttribute(
            "pattern",
            "http(?:s?)://(?:www.)?youtu(?:be.com/watch?v=|.be/)([w-_]*)(&(amp;)?[w?=]*)?"
          );
        // Regex initial avant erreur compil escape chars : http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?[\w\?=]*)?
        break;
      case "wordpress":
        this.$el
          .querySelector("input")
          .setAttribute("pattern", "^https?://.*/$");
        // Regex initial avant erreur compil escape chars : ^https?:\/\/.*\/$
        break;
      default:
        this.$el.querySelector("input").setAttribute("pattern", ".*");
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
</style>
