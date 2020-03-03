<template>
  <div>
    <button
      type="button"
      class="btn btn-primary"
      @click="$emit('onClick')"
    >
      {{ text }}
      <font-awesome-icon
        v-show="icon"
        class="icon"
        icon="external-link-alt"
      />
    </button>
  </div>
</template>
<!-- Le classList.add("btn-secondary") ajoutera btn-secondary APRES btn-primary, Ã©crasant le CSS -->

<script>
export default {
  name: 'TextButton',
  props: {
    text: {
      type: String,
      required: true,
    },
    secondary: Boolean,
    form: Boolean,
    icon: Boolean
  },
  mounted() {
    this.checkForm();
    this.addSecondaryClass();
  },
  methods: {
    checkForm: function() {
      if (this.form) {
        this.$el.querySelector('button').setAttribute('type', 'submit');
      } else {
        this.$el.querySelector('button').setAttribute('type', 'button');
      }
    },
    addSecondaryClass: function() {
      if (this.secondary) {
        this.$el.querySelector('button').classList.add('btn-outline-primary');
        this.$el.querySelector('button').classList.remove('btn-primary');
      } else {
        this.$el.querySelector('button').classList.add('btn-primary');
        this.$el.querySelector('button').classList.remove('btn-outline-primary');
      }
    }
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.btn {
  padding: 0.5rem 1rem;
  line-height: 1;
  border-radius: var(--spacing-sm);
}
.btn-primary {
  font-family: Caveat;
  color: var(--black);
}
.btn-primary:hover {
  color: var(--light);
}
.btn-outline-primary {
  font-family: Caveat;
}
.icon {
  margin-left: var(--spacing-sm);
}
@media (max-width: 480px) {
  .btn {
    padding: 0.25rem 0.5rem;
  }
}
</style>
