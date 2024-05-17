<template>
  <div>
    <q-linear-progress v-if="loading" indeterminate />
    <div class="q-gutter-md">

      <InputAndSaveProxy
        v-model="apiKey"
        label="API Яндекс.Расписаний"
        outlined
        :func="updateYandexScheduleSettings"
        name="apiKey"
        @success="getData"
      />
      <div>
        <InputAndSaveProxy
          v-model="to"
          label="Код станции отправления"
          outlined
          :func="updateYandexScheduleSettings"
          name="to"
          @success="getData"
        />
        <div class="text-small-80 o-70  q-px-md">
          Должен быть указан в системе <a href="https://yandex.ru/dev/rasp/doc/ru/concepts/coding-system" class="text-primary">кодирования</a>.
        </div>
      </div>
      <div>
        <InputAndSaveProxy
          v-model="from"
          label="Код станции прибытия"
          outlined
          :func="updateYandexScheduleSettings"
          name="from"
          @success="getData"
        />
        <div class="text-small-80 o-70  q-px-md">
          Должен быть указан в системе <a href="https://yandex.ru/dev/rasp/doc/ru/concepts/coding-system" class="text-primary">кодирования</a>.
        </div>
      </div>
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, onMounted, ref } from 'vue'
import ShowTime from 'components/ShowTime/index.vue'
import ShowDuration from 'src/components/ShowDuration/index.vue'
import FilterForm from './components/FilterForrm/index.vue'
import ItemBlock from './components/ItemBlock/index.vue'
import { fetchYandexScheduleSettings, updateYandexScheduleSettings } from 'src/Modules/Yandex/api/schedule'
import InputAndSaveProxy from 'components/Input/InputAndSaveProxy/index.vue'

export default defineComponent({
  components: {
    InputAndSaveProxy,
    ShowTime,
    ShowDuration,
    FilterForm,
    ItemBlock
  },
  props: {},
  setup(props, { emit }) {
    const loading = ref(false)
    const apiKey = ref(null)
    const from = ref(null)
    const to = ref(null)
    const getData = () => {
      loading.value = true
      fetchYandexScheduleSettings()
        .then(res => {
          apiKey.value = res.data.token
          from.value = res.data.from
          to.value = res.data.to
        })
        .finally(() => {
          loading.value = false
        })
    }
    onMounted(() => {
      getData()
    })
    return {
      getData,
      loading,
      updateYandexScheduleSettings,
      apiKey,
      from,
      to
    }
  }
})
</script>

<style scoped>

</style>
