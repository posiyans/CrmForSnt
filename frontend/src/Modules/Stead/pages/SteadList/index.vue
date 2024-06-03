<template>
  <div class="q-pa-md">
    <div class="row items-center q-col-gutter-md q-pb-sm">
      <FilterBlock v-model="listQuery" />
      <DownloadXlsxFileBtn :func="funcXlsx" />
      <div>
        <AddStead @success="handleFilter" />
      </div>
      <q-space />
      <div>

        <q-btn flat icon="settings" color="grey" to="/admin/stead/options" />
      </div>
    </div>
    <TableBlock :list="list" @reload="handleFilter" />
    <LoadMore :key="key" v-model:listQuery="listQuery" :func="func" @setList="setList" />
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, ref } from 'vue'

import LoadMore from 'src/components/LoadMore/index.vue'
import FilterBlock from './components/FilterBlock/index.vue'
import { fetchSteadListInXlsx, getSteadsList } from 'src/Modules/Stead/api/stead'
import AddStead from 'src/Modules/Stead/components/AddStead/index.vue'
import TableBlock from './components/TableBlock/index.vue'
import DownloadXlsxFileBtn from 'src/Modules/Files/components/DownloadXlsxFileBtn/index.vue'

export default defineComponent({
  components: {
    DownloadXlsxFileBtn,
    LoadMore,
    FilterBlock,
    TableBlock,
    AddStead
  },
  props: {},
  setup(props, { emit }) {
    const key = ref(1)
    const list = ref([])
    const func = getSteadsList
    const setList = (val) => {
      list.value = val
    }
    const handleFilter = () => {
      key.value++
    }
    const funcXlsx = computed(() => {
      const params = Object.assign({}, listQuery.value)
      params.xlsx = 1
      return () => {
        return fetchSteadListInXlsx(params)
      }
    })
    const listQuery = ref({
      page: 1,
      limit: 20,
      admin: 1,
      steadsId: [],
      fields: []
    })
    return {
      list,
      setList,
      funcXlsx,
      handleFilter,
      key,
      func,
      listQuery
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
