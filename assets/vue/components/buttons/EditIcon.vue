<template>
  <div>
    <button
      type="submit"
      @click="editable()"
    >
      <!-- Affichage du bouton edit ou check -->
      <font-awesome-icon
        class="edit"
        size="2x"
        :icon="icon"
      />
    </button>
  </div>
</template>

<script>
import { readonlyBus } from "../../index.js";

export default {
  name: "EditIcon",
  data() {
    return {
      icon: "edit",
      isEdit: true
    }
  },
  methods: {
    editable() {
      this.isEdit = !this.isEdit;
      readonlyBus.$emit("readonlyStatus", this.isEdit);
      if (this.isEdit) {
        this.icon = "edit";
        this.$emit('onClick');
      }
      else {
        this.icon = "check-square";
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.edit {
  color: var(--light);
}
button {
  background: transparent;
  border: 0;
}
</style>
