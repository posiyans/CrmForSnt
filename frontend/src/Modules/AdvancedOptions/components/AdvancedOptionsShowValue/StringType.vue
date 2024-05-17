<template>
  <div>
    {{ modelValue.value }} {{ modelValue.options.options.unitName }}
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
