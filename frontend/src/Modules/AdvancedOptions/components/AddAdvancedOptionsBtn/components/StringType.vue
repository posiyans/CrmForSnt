<template>
  <div>
    <q-input
      :model-value="modelValue.name"
      outlined
      label="Название поля"
      :rules="[required]"
      @update:model-value="setValue"
    />
    <q-input
      :model-value="modelValue.options.unitName"
      outlined
      hint="Оставить пустым если нет"
      label="Единица измерения"
      @update:model-value="setUnit"
    />
  </div>
</template>

<script>
import { defineComponent, onMounted, ref } from 'vue'
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
    const setValue = (val) => {
      const tmp = Object.assign({}, props.modelValue)
      tmp.name = val
      emit('update:model-value', tmp)
    }
    const setUnit = (val) => {
      const tmp = Object.assign({}, props.modelValue)
      tmp.options.unitName = val
      emit('update:model-value', tmp)
    }
    onMounted(() => {
      const tmp = Object.assign({}, props.modelValue)
      tmp.options = {
        unitName: ''
      }
      emit('update:model-value', tmp)
    })
    return {
      data,
      setValue,
      required,
      setUnit
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
