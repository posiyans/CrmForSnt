<template>
  <div>
    <div v-if="error" class="text-red text-h4">
      {{ error }}
    </div>
    <div v-else>
      <FilterForm
        v-model="queryParams"
        @update:model-value="getList"
        :toLabel="toLabel"
        :fromLabel="fromLabel"
      />
      <div class="q-pt-md">
        <q-linear-progress v-show="loading" :indeterminate="loading" size="3px" />
      </div>
      <div :class="{ 'o-10': loading }">
        <div
          v-for="item in list.segments"
          :key="item.thread.uid"
          class="q-pa-xs"
        >
          <q-card>
            <q-card-section class="q-pa-sm">
              <ItemBlock
                :item="item"
                :type="queryParams.type"
              />
            </q-card-section>
          </q-card>
        </div>
      </div>
      <div class="q-pa-lg text-right">
        <div>
          <a
            href="https://rasp.yandex.ru/search/?fromId=c2&fromName=Санкт-Петербург&toId=s9602670&toName=Чаща"
            target="_blank"
            class="text-primary"
          >
            Данные предоставлены сервисом Яндекс.Расписания
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, onMounted, ref } from 'vue'
import { fetchYandexSchedule } from 'src/Modules/Yandex/api/schedule.js'
import ShowTime from 'components/ShowTime/index.vue'
import ShowDuration from 'src/components/ShowDuration/index.vue'
import FilterForm from './components/FilterForrm/index.vue'
import ItemBlock from './components/ItemBlock/index.vue'

export default defineComponent({
  components: {
    ShowTime,
    ShowDuration,
    FilterForm,
    ItemBlock
  },
  props: {},
  setup(props, { emit }) {
    const error = ref(null);
    const queryParams = ref({
      type: 0,
      back: false
    })
    const list = ref([])
    const toLabel = ref(undefined)
    const fromLabel = ref(undefined)
    const loading = ref(false)
    const getList = () => {
      loading.value = true
      fetchYandexSchedule(queryParams.value)
        .then(response => {
          list.value = response.data
          if (queryParams.value.type === 0 && !queryParams.value.back) {
            if (!fromLabel.value) {
              fromLabel.value = list.value.search.from.short_title || list.value.search.from.popular_title || list.value.search.from.title
            }
            if (!toLabel.value) {
              toLabel.value = list.value.search.to.short_title || list.value.search.to.popular_title || list.value.search.to.title
            }
          }
        })
        .catch(er => {
          error.value = er.response.data.errors
        })
        .finally(() => {
          loading.value = false
        })
    }
    onMounted(() => {
      getList()
    })
    return {
      queryParams,
      list,
      error,
      getList,
      toLabel,
      fromLabel,
      loading
    }
  }
})
</script>

<style scoped>

</style>
