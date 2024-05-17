<template>
  <component
    :is="componentName"
    :model-value="item"
  >
  </component>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent } from 'vue'
import StringType from 'src/Modules/AdvancedOptions/components/AdvancedOptionsShowValue/StringType.vue'
import BooleanType from 'src/Modules/AdvancedOptions/components/AdvancedOptionsShowValue/BooleanType.vue'
import SelectType from 'src/Modules/AdvancedOptions/components/AdvancedOptionsShowValue/SelectType.vue'

export default defineComponent({
  components: {
    StringType,
    BooleanType,
    SelectType
  },
  props: {
    item: {
      type: Object,
      required: () => {
        return {}
      }
    }
  },
  setup(props, { emit }) {
    const componentName = computed(() => {
      if (props.item?.options?.type_value.key === 'string') {
        return StringType
      } else if (props.item?.options?.type_value.key === 'boolean') {
        return BooleanType
      } else if (props.item?.options?.type_value.key === 'select') {
        return SelectType
      } else if (props.item?.options?.type_value.key === 'multi_select') {
        return SelectType
      }
      return 'div'
    })
    return {
      componentName
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
