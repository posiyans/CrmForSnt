<template>
  <div class="q-pa-md">
    <DropDownBlock show-label="Статистика" hide-label="Статистика">
      <BalanceGrid />
    </DropDownBlock>
    <div class="row items-center q-col-gutter-sm">
      <FilterBlock v-model="listQuery" />
      <DownloadXlsxBtn :func="funcXlsx" />
      <q-space />
    </div>
    <ShowTable :list="list" class="q-pt-sm" />
    <LoadMore v-model:list-query="listQuery" :func="func" @setList="setList" />
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, ref } from 'vue'
import ShowTable from './components/ShowTable/index.vue'
import LoadMore from 'src/components/LoadMore/index.vue'
import FilterBlock from './components/FiltersBlock/index.vue'
import { getBalanceList, getBalanceListXlsx } from 'src/Modules/Bookkeeping/api/balaceApi'
import DownloadXlsxBtn from 'src/Modules/Files/components/DownloadXlsxFileBtn/index.vue'
import BalanceGrid from 'src/Modules/Bookkeeping/components/Balance/BalanceGrid/index.vue'
import DropDownBlock from 'components/DropDownBlock/index.vue'

export default defineComponent({
  components: {
    DropDownBlock,
    ShowTable,
    FilterBlock,
    BalanceGrid,
    DownloadXlsxBtn,
    LoadMore
  },
  props: {},
  setup(props, { emit }) {
    const key = ref(1)
    const list = ref([])
    const func = getBalanceList
    const listQuery = ref({
      find: '',
      rate_group_id: '',
      duty: '',
      zero_line: 0,
      page: 1,
      limit: 20
    })
    const setList = (val) => {
      list.value = val
    }
    const funcXlsx = computed(() => {
      const tmp = Object.assign({}, listQuery.value)
      tmp.xlsx = 1
      return () => {
        return getBalanceListXlsx(tmp)
      }
    })
    return {
      listQuery,
      funcXlsx,
      key,
      setList,
      func,
      list
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
