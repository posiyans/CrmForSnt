import { computed, ref } from 'vue'
import { getSteadsList } from 'src/Modules/Stead/api/stead'

const allSteads = ref([])
const loading = ref(false)
const getData = () => {
  loading.value = true
  getSteadsList()
    .then(res => {
      allSteads.value = res.data.data
    })
    .finally(() => {
      loading.value = false
    })
}
getData()

export function useSteadsList() {
  const steads = ref([])
  const steadsObject = computed(() => {
    return allSteads.value.filter(item => {
      return steads.value.includes(item.id)
    })
  })
  return {
    loading,
    allSteads,
    steadsObject,
    steads
  }
}
