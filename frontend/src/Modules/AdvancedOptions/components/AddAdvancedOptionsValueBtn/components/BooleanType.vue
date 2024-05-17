<template>
  <div>
    <q-toggle
      :label="toggleLabel"
      :model-value="modelValue"
      @update:model-value="setValue"
    />
  </div>

</template>

<script>
/* eslint-disable */
import { computed, defineComponent, onMounted } from 'vue'

export default defineComponent({
  components: {},
  props: {
    modelValue: {
      type: Object,
      default: () => {
      }
    },
    options: {
      type: Object,
      default: () => {
        return {
          defaultValue: false
        }
      }
    }
  },
  setup(props, { emit }) {
    const toggleLabel = computed(() => {
      return props.modelValue ? 'ДА' : 'НЕТ'
    })
    const setValue = (val) => {
      emit('update:model-value', val)
    }
    onMounted(() => {
      emit('update:model-value', props.options.defaultValue || false)
    })
    return {
      setValue,
      toggleLabel
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
