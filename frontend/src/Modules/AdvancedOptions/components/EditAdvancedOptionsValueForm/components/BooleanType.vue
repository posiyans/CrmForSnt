<template>
  <div>
    <q-toggle
      :label="toggleLabel"
      :model-value="modelValue"
      :dense="dense"
      @update:model-value="setValue"
    />
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
    },
    dense: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const toggleLabel = computed(() => {
      return props.modelValue ? 'ДА' : 'НЕТ'
    })
    const setValue = (val) => {
      emit('update:model-value', val)
    }
    return {
      setValue,
      toggleLabel
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
