<template>
  <div>
    <div class="row items-center q-mb-sm">
      <div>
        <DropDownBlock only-mobile class="">
          <FilterBlock v-model="listQuery" />
        </DropDownBlock>
      </div>
      <DownloadXlsxFileBtn :func="funcXlsx" />
    </div>
    <TableBlock :list="list" :edit="edit" @reload="reload" />
    <LoadMore :key="key" v-model:listQuery="listQuery" :func="func" @setList="setList" />
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, ref } from 'vue'
import FilterBlock from './components/FilterBlock/index.vue'
import LoadMore from 'src/components/LoadMore/index.vue'
import { getInstrumentReadingList, getInstrumentReadingListXlsx } from 'src/Modules/MeteringDevice/api/instrumentReadingApi'
import TableBlock from './components/TableBlock/index.vue'
import DropDownBlock from 'components/DropDownBlock/index.vue'
import DownloadXlsxFileBtn from 'src/Modules/Files/components/DownloadXlsxFileBtn/index.vue'

export default defineComponent({
  components: {
    FilterBlock,
    DownloadXlsxFileBtn,
    DropDownBlock,
    LoadMore,
    TableBlock

  },
  props: {
    steadId: {
      type: [String, Number],
      default: ''
    },
    edit: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const key = ref(1)
    const list = ref([])
    const func = getInstrumentReadingList
    const funcXlsx = computed(() => {
      const tmp = Object.assign({}, listQuery.value)
      tmp.xlsx = 1
      return () => {
        return getInstrumentReadingListXlsx(tmp)
      }
    })
    const listQuery = ref({
      stead_id: props.steadId,
      rate_group_id: '',
      rate_type_id: '',
      date_start: '',
      date_end: '',
      page: 1,
      limit: 20
    })
    const reload = () => {
      key.value++
    }
    const setList = (val) => {
      list.value = val
    }
    return {
      key,
      funcXlsx,
      reload,
      list,
      listQuery,
      func,
      setList
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
