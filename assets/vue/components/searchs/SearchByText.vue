<template>
  <div class="input-group">
    <input
      class="form-control"
      type="text"
      placeholder="Recherche par nom"
      :value="value"
      @input="emitValue($event)"
    >
  </div>
</template>

<script>
import { searchBus } from "../../index.js";

export default {
  name: "SearchByText",
  data() {
    return {
      value: ""
    };
  },
  methods: {
    emitValue($event) {
      searchBus.$emit("input-text", $event.target.value);
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped></style>
