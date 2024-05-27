<template>
  <div style="min-width: 150px;">
    <AdvancedOptionsShowValue v-if="item.value !== ''" :item="item" />
    <div v-else>&nbsp;</div>
    <q-popup-edit v-if="edit" :model-value="item" v-slot="scope">
      <EditAdvancedOptionsValueForm :option="scope.value" @success="reload(scope)" />
    </q-popup-edit>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import AdvancedOptionsShowValue from 'src/Modules/AdvancedOptions/components/AdvancedOptionsShowValue/index.vue'
import EditAdvancedOptionsValueForm from 'src/Modules/AdvancedOptions/components/EditAdvancedOptionsValueForm/index.vue'

export default defineComponent({
  components: {
    AdvancedOptionsShowValue,
    EditAdvancedOptionsValueForm
  },
  props: {
    item: {
      type: Object,
      required: true
    },
    edit: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const data = ref(false)
    const reload = (scope) => {
      scope.cancel()
      emit('success')
    }
    return {
      data,
      reload
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
