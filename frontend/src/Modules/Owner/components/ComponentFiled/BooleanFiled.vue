<template>
  <div style="min-width: 250px;">
    <q-select
      outlined
      :model-value="modelValue"
      dense
      :options="[
        {
         label: 'Нет',
         value:  '0'
        },
        {
           label: 'Да',
           value:  '1'
        }
     ]"
      map-options
      emit-value
      :rules="rules"
      :label="label"
      @update:model-value="setValue"
    />
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent } from 'vue'

export default defineComponent({
  components: {},
  props: {
    modelValue: {
      type: [Number, String],
      default: ''
    },
    rules: {
      type: Array,
      default: () => []
    },
    label: {
      type: String,
      default: null
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

<style scoped>

</style>
