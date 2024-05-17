<template>
  <div>
    <q-input
      :model-value="modelValue"
      outlined
      label="Значение"
      clearable
      :dense="dense"
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
import { defineComponent } from 'vue'

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
    },
    dense: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const setValue = (val) => {
      emit('update:model-value', val)
    }
    return {
      setValue
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
