<template>
  <div>
    <div v-for="item in list" :key="item.id" class="q-mb-sm">
      <ArticlePreview :article="item" />
    </div>
    <LoadMore :key="key" v-model:list-query="listQuery" :func="fetchListForCategory" @setList="setList" />
  </div>
</template>

<script>
import ArticlePreview from 'src/Modules/Article/Article/components/ArticlePreview/index.vue'
import { fetchListForCategory } from 'src/Modules/Article/Article/api/article.js'
import { defineComponent, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import LoadMore from 'components/LoadMore/index.vue'

export default defineComponent({
  components: {
    ArticlePreview,
    LoadMore
  },
  setup() {
    const route = useRoute()
    const list = ref([])
    const key = ref(1)
    const listQuery = ref({
      page: 1,
      limit: 5,
      sort: '-time'
    })

    const setList = (val) => {
      list.value = val
    }
    const getData = () => {
      list.value = []
    }

    watch(
      () => route.params.uid,
      () => {
        key.value++
        getData()
      }
    )

    return {
      list,
      key,
      listQuery,
      setList,
      fetchListForCategory
    }
  }
})
</script>

<style scoped>

</style>
