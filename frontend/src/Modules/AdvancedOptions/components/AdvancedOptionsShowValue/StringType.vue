<template>
  <div>
    {{ modelValue.value }} <span v-if="modelValue.value">
      {{ modelValue.options.options.unitName }}
    </span>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent } from 'vue'

export default defineComponent({
  components: {},
  props: {
    modelValue: {
      type: Object,
      default: () => {
      }
    }
  },
  setup(props, { emit }) {
    return {}
  }
})
</script>

<style scoped lang='scss'>

</style>
