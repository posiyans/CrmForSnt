<template>
  <div>
    <div v-if="multiSelect" class="row items-center value-list">
      <div v-for="val in modelValue.value" :key="val">
        {{ val }} <span v-if="modelValue.options.options.unitName">{{ modelValue.options.options.unitName }}</span>
      </div>
    </div>
    <div v-else>
      {{ modelValue.value }} <span v-if="modelValue.value">
      {{ modelValue.options.options.unitName }}
    </span>
    </div>
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
    const multiSelect = computed(() => {
      return props.modelValue.options.type_value.key === 'multi_select' && props.modelValue.value.length > 1
    })
    return {
      multiSelect
    }
  }
})
</script>

<style scoped lang='scss'>
.value-list div:not(:last-child):after {
  content: ', ';
  margin-right: 5px;
}
</style>
