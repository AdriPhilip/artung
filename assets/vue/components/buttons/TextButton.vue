<template>
  <div>
    <button
      type="button"
      class="btn btn-primary"
      @click.prevent="$emit('onClick')"
    >
      {{ text }}
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
  },
  mounted() {
    // this.isSecondary();
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
        this.$el
          .querySelector('button')
          .classList.remove('btn-outline-primary');
        // alert("removed !")
      }
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
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
</style>
