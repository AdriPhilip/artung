<template>
  <div class="form-group">
    <label :for="formGroup">{{ text }}</label>
    <input
      :id="formGroup"
      v-model="model"
      class="form-control"
      :placeholder="placeholder"
      :required="required"
      :type="type"
      :maxlength="maxlength"
      :readonly="readonly"
      @input="$emit('input', model)"
    >
  </div>
</template>

<script>
import { readonlyBus } from "../../index.js";
export default {
  name: "FormGroup",
  props: {    
    text: {
      type: String,
      required: true
    },
    formGroup: {
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
  created() {
    readonlyBus.$on("readonlyStatus", data => {
      this.readonly = data;
    });
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
</style>
