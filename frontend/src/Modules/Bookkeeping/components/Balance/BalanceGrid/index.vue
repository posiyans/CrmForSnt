<template>
  <div>
    <SteadGrid
      :color-stead="colors"
      :loading="loading"
      @steadClick="callback"
    >
      <template v-slot:after="{steadId}">
        <div class="text-small-80">
          <ShowPrice :price="tooltips[steadId]" />
        </div>
      </template>
    </SteadGrid>
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import SteadGrid from 'src/Modules/Stead/components/SteadGrid/index.vue'
import { getBalanceList } from 'src/Modules/Bookkeeping/api/balaceApi'
import ShowPrice from 'components/ShowPrice/index.vue'

export default defineComponent({
  components: {
    SteadGrid,
    ShowPrice
  },
  props: {},
  setup(props, { emit }) {
    const router = useRouter()
    const callback = (stead_id) => {
      router.push('/admin/stead/info/' + stead_id + '?tab=payment')
    }
    const loading = ref(true)
    const data = ref(null)
    const list = ref([])
    const listQuery = ref({
      find: '',
      rate_group_id: '',
      duty: '',
      zero_line: 0,
      page: 1,
      limit: 1
    })
    const colors = computed(() => {
      const obj = {}
      list.value.forEach(item => {
        obj[item.stead.id] = item.price < 0 ? 'red' : 'teal'
      })
      return obj
    })
    const tooltips = computed(() => {
      const obj = {}
      list.value.forEach(item => {
        obj[item.stead.id] = item.price
      })
      return obj
    })
    const getData = () => {
      getBalanceList(listQuery.value)
        .then(res => {
          list.value = res.data.data
          loading.value = false
        })
    }
    onMounted(() => {
      getBalanceList(listQuery.value)
        .then(res => {
          listQuery.value.limit = res.data.meta.total
          getData()
        })
    })
    return {
      data,
      colors,
      loading,
      tooltips,
      callback
    }
  }
})
</script>

<style scoped>

</style>
