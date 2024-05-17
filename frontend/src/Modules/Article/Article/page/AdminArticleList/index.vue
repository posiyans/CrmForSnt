<template>
  <div class="q-pa-md">
    <div class="row items-center q-pb-sm no-wrap">
      <DropDownBlock only-mobile>
        <FilterBlock v-model="listQuery" />
      </DropDownBlock>
      <div>
        <q-btn icon="sync" flat color="primary" @click="key++" />
      </div>
    </div>
    <TableBlock :list="list" />
    <LoadMore :key="key" v-model:list-query="listQuery" change-url :func="fetchAdminArticleList" @setList="setList" />
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import { fetchAdminArticleList } from 'src/Modules/Article/Article/api/articleAdminApi.js'
import LoadMore from 'src/components/LoadMore/index.vue'
import TableBlock from './components/TableBlock/index.vue'
import FilterBlock from './components/FilterBlock/index.vue'
import DropDownBlock from 'components/DropDownBlock/index.vue'

export default defineComponent({
  components: {
    TableBlock,
    FilterBlock,
    LoadMore,
    DropDownBlock
  },
  props: {},
  setup(props, { emit }) {
    const list = ref([])
    const key = ref(1)
    const listQuery = ref({
      page: 1,
      limit: 20,
      find: '',
      status: '',
      category: ''
    })
    const setList = (val) => {
      list.value = val
    }
    return {
      list,
      key,
      listQuery,
      setList,
      fetchAdminArticleList
    }
  }
})
</script>
