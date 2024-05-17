<template>
  <div>
    <div>
      <q-input
        :model-value="modelValue.name"
        outlined
        label="Название поля"
        :rules="[required]"
        @update:model-value="setValue"
      />
    </div>
    <div>
      <q-toggle
        :label="toggleLabel"
        :model-value="modelValue.options.defaultValue"
        @update:model-value="setDefaultValue"
      />
    </div>
  </div>
</template>

<script>
import { computed, defineComponent, onMounted, ref } from 'vue'
import { required } from 'src/utils/validators.js'

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
    const data = ref(false)
    const toggleLabel = computed(() => {
      const tmp = props.modelValue.options.defaultValue ? 'ДА' : 'НЕТ'
      return 'Значение по умолчанию ' + tmp
    })
    const setValue = (val) => {
      const tmp = Object.assign({}, props.modelValue)
      tmp.name = val
      emit('update:model-value', tmp)
    }
    const setDefaultValue = (val) => {
      const tmp = Object.assign({}, props.modelValue)
      tmp.options.defaultValue = val
      emit('update:model-value', tmp)
    }
    onMounted(() => {
      const tmp = Object.assign({}, props.modelValue)
      tmp.options = {
        defaultValue: false
      }
      emit('update:model-value', tmp)
    })
    return {
      data,
      setValue,
      setDefaultValue,
      required,
      toggleLabel
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
