<template>
  <div>
    <div>
      <q-btn icon="more_vert" flat size="md" color="grey" @click="showDialog" />
    </div>
    <q-dialog
      v-model="dialogVisible"
      @hide="setValue"
    >
      <q-card style="min-width:250px; min-height:250px;">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Настройка полей</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-card-section>
          <AdvancedOptionsList
            v-model="localValue"
            object-name="stead"
            type="options"
            show-checkbox
          />
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import AdvancedOptionsList from 'src/Modules/AdvancedOptions/components/AdvancedOptionsList/index.vue'

export default defineComponent({
  components: {
    AdvancedOptionsList
  },
  props: {
    modelValue: {
      type: Array,
      default: () => []
    }
  },
  setup(props, { emit }) {
    const dialogVisible = ref(false)
    const localValue = ref([])
    const showDialog = () => {
      localValue.value = props.modelValue
      dialogVisible.value = true
    }
    const setValue = (val) => {
      // localValue.value = val
      emit('update:model-value', localValue.value)
    }
    return {
      dialogVisible,
      localValue,
      showDialog,
      setValue
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
