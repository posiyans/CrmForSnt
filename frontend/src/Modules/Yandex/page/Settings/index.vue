<template>
  <div>
    <div class="page-title">
      Настройки Яндекс
    </div>
    <q-tabs
      v-model="tab"
      dense
      class="text-black"
      active-color="primary"
      indicator-color="primary"
      align="left"
      inline-label
      narrow-indicator
    >
      <q-tab name="Schedule" icon="train" label="Расписание" />
    </q-tabs>
    <q-separator />
    <q-tab-panels v-model="tab" animated>
      <q-tab-panel name="Schedule">
        <YandexScheduleSettings />
      </q-tab-panel>
    </q-tab-panels>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import YandexScheduleSettings from 'src/Modules/Yandex/components/YandexScheduleSettings/index.vue'

export default defineComponent({
  components: {
    YandexScheduleSettings
  },
  props: {},
  setup(props, { emit }) {
    const tab = ref('Schedule')
    return {
      tab
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
