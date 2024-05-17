<template>
  <div>
    {{ showValue }}
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent } from 'vue'

export default defineComponent({
  components: {},
  props: {
    modelValue: {
      default: ''
    }
  },
  setup(props, { emit }) {
    const showValue = computed(() => {
      if (props.modelValue === '') {
        return 'Неизвестно'
      } else if (props.modelValue === true || +props.modelValue === 1) {
        return 'Да'
      } else {
        return 'Нет'

      }
    })
    return {
      showValue
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
