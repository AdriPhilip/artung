<template>
  <div class="form-group">
    <label
      :for="formGroupInline"
      class="formGroupInlineCss"
    >{{ text }}</label>
    <span v-switch="icon">
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
      <span v-default>"''"</span>
    </span>
    &nbsp;
    <input
      :id="formGroupInline"
      v-model="model"
      class="form-control"
      :placeholder="placeholder"
      @input="$emit('input', model)"
    >
  </div>
</template>

<script>
import {vSwitch, vCase, vDefault} from 'v-switch-case';
import {readonlyBus} from '../../index.js';

export default {
  name: 'FormGroupInline',
  directives: {
    switch: vSwitch,
    case: vCase,
    default: vDefault,
  },
  props: {
    text: {
      type: String,
      default: '',
    },
    iconStatus: {
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
      readonlyValue: true,
    };
  },
  watch: {
    readonlyValue: function() {
      this.$el.querySelector('input').toggleAttribute('readonly');
    },
  },
  created() {
    readonlyBus.$on('readonlyStatus', data => {
      this.readonlyValue = data;
    });
  },
  mounted() {
    this.iconChange();
  },
  methods: {
    iconChange: function() {
      switch (this.iconStatus) {
      case 'facebook':
        this.icon = 'facebook';
        break;
      case 'twitter':
        this.icon = 'twitter';
        break;
      case 'youtube':
        this.icon = 'youtube';
        break;
      case 'wordpress':
        this.icon = 'wordpress';
        break;
      default:
        this.icon = '';
      }
      this.$forceUpdate();
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
svg {
  color: var(--light);
  /*font-size: 150%;*/
}
.formGroupInlineCss {
  font-size: 3em;
  color: var(--light);
  font-family: 'Caveat';
}
</style>
