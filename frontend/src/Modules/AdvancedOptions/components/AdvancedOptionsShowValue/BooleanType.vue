<template>
  <div>
    {{ toggleLabel }} {{ modelValue.options.options.unitName }}
  </div>

</template>

<script>
/* eslint-disable */
import { computed, defineComponent } from 'vue'

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
    const toggleLabel = computed(() => {
      return props.modelValue.value ? 'ДА' : 'НЕТ'
    })
    return {
      toggleLabel
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
