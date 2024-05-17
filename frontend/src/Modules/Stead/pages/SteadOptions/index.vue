<template>
  <div>
    <q-tabs
      v-model="tab"
      align="left"
      dense
      class="text-teal"
      :breakpoint="0"
    >
      <q-tab name="advanced_options" label="Поля" />
    </q-tabs>
    <q-separator color="teal" />
    <q-tab-panels v-model="tab" animated>
      <q-tab-panel name="advanced_options">
        <div class="row items-center q-col-gutter-sm">
          <div>
            Дополнительные поля для участков
          </div>
          <AddAdvancedOptionsBtn
            object-name="stead"
            type="options"
          />
        </div>
        <AdvancedOptionsList object-name="stead" type="options" />
      </q-tab-panel>
    </q-tab-panels>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import AddAdvancedOptionsBtn from 'src/Modules/AdvancedOptions/components/AddAdvancedOptionsBtn/index.vue'
import AdvancedOptionsList from 'src/Modules/AdvancedOptions/components/AdvancedOptionsList/index.vue'

export default defineComponent({
  components: {
    AddAdvancedOptionsBtn,
    AdvancedOptionsList
  },
  props: {},
  setup(props, { emit }) {
    const tab = ref('advanced_options')
    return {
      tab
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
