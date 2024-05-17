<template>
  <div>
    <q-input
      :model-value="modelValue"
      outlined
      label="Значение"
      clearable
      @update:model-value="setValue"
    >
      <template v-slot:append>
        <div>
          {{ options.unitName }}
        </div>
      </template>
    </q-input>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, onMounted } from 'vue'
import { required } from 'src/utils/validators.js'

export default defineComponent({
  components: {},
  props: {
    modelValue: {
      type: String,
      default: ''
    },
    options: {
      type: Object,
      default: () => {
        return {
          selectOptions: [],
          unitName: ''
        }
      }
    }
  },
  setup(props, { emit }) {
    const setValue = (val) => {
      emit('update:model-value', val)
    }
    onMounted(() => {
      emit('update:model-value', '')
    })
    return {
      setValue,
      required
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
