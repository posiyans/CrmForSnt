import { getAdvancedOptionsList } from 'src/Modules/AdvancedOptions/api/advancedOptionsApi'
import { computed, onMounted, ref } from 'vue'

export function useAdvancedOptionsList(objectName, type) {
  const optionsList = ref([])
  const getData = () => {
    const data = {
      object: objectName,
      type: type
    }
    getAdvancedOptionsList(data)
      .then(res => {
        optionsList.value = res.data.data
      })
  }
  const option = computed(() => {
    return (id) => {
      return optionsList.value.find(opt => opt.id === +id) || {}
    }
  })
  onMounted(() => {
    getData()
  })
  return {
    optionsList,
    option
  }
}
