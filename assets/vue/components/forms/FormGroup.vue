<template>
  <div class="form-group">
    <label
      :for="formGroup"
    >{{ text }}</label>
    <input
      :id="formGroup"
      v-model="value"
      class="form-control"
      :placeholder="placeholder"
      autocomplete="off"
      :required="required"
      :type="type"
      :maxlength="maxlength"
      :readonly="readonly"
      @change="$emit('change', value)"
    >
  </div>
</template>

<script>
import { readonlyBus } from "../../index.js";
export default {
  name: "FormGroup",
  model: {
    prop: 'value',
    event: 'change'
  },
  props: {    
    text: {
      type: String,
      required: true
    },
    formGroup: {
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
    required: Boolean,
    type: {
      type: String,
      required: true
    },
    maxlength: {
      type: String,
      default: ""
    },
    readonly: Boolean
  },
  mounted() {
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
    addFormControlPlaintext: function() {
      if (this.readonly) {
        this.$el.querySelector("input").classList.remove("form-control");
        this.$el.querySelector("input").classList.add("form-control-plaintext");
      } else {
        this.$el.querySelector("input").classList.add("form-control");
        this.$el.querySelector("input").classList.remove("form-control-plaintext");
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
label {
  font-size: 2em;
  color: var(--light);
  font-family: "Caveat";
}

.form-control-plaintext {
  color: var(--light);
}
</style>
