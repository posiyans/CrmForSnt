<template>
  <div>
    <AdvancedSelectedStead
      :model-value="modelValue.steadsId"
      label="Найти"
      outlined
      dense
      @update:model-value="setValue($event, 'steadsId')"
    />
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent } from 'vue'
import AdvancedSelectedStead from 'src/Modules/Stead/components/AdvancedSelectedStead/index.vue'

export default defineComponent({
  components: {
    AdvancedSelectedStead
  },
  props: {
    modelValue: {
      type: Object,
      required: true
    }
  },
  setup(props, { emit }) {
    const setValue = (val, field) => {
      const tmp = Object.assign({}, props.modelValue)
      tmp[field] = val
      tmp.page = 1
      emit('update:model-value', tmp)
    }
    return {
      setValue
    }
  }
})
</script>

<style scoped>

</style>
