<template>
  <div>
    <div v-if="loading">
      <q-spinner
        color="primary"
        size="3em"
      />
    </div>
    <div v-else>
      <div class="row items-center">
        <q-input
          v-model="find"
          :outlined="outlined"
          :dense="dense"
          :label="label"
          clearable
          class="col-grow"
        />
        <q-checkbox v-model="invertFind" label="Инвертировать результат" />
      </div>
      <div class="row overflow-hidden">
        <transition-group
          enter-active-class="animated backInDown"
          leave-active-class="animated backOutUp"
        >
          <div v-for="item in filteredList" :key="item.id" class="cursor-pointer" @click="selectItem(item)">
            <ShowItem :item="item" :find="find" />
          </div>
        </transition-group>
      </div>
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, onMounted, ref } from 'vue'
import { getSteadsList } from 'src/Modules/Stead/api/stead'
import ShowItem from './components/ShowItem/index.vue'

export default defineComponent({
  components: {
    ShowItem
  },
  props: {
    modelValue: {
      type: Array,
      default: () => []
    },
    label: {
      type: String,
      default: 'Найти'
    },
    dense: {
      type: Boolean,
      default: false
    },
    outlined: {
      type: Boolean,
      default: false
    },
  },
  setup(props, { emit }) {
    const loading = ref(false)
    const find = ref('')
    const invertFind = ref(false)
    const selectedSteads = computed(() => {
      return list.value.filter(item => {
        return props.modelValue.includes(item.id)
      }).sort(function (a, b) {
        return a.number - b.number
      })
    })
    const list = ref([])
    const filteredList = computed(() => {
      return list.value.filter(item => {
        return !props.modelValue.includes(item.id)
      })
        .filter(item => {
          let status = invertFind.value
          item.find = 'Не найдено ' + find.value
          if (find.value) {
            if (item?.number.toLowerCase().indexOf(find.value) !== -1) {
              item.find = 'Номер: ' + item.number
              status = !invertFind.value
            } else {
              item?.owners?.forEach(owner => {
                if (owner.fullName.toLowerCase().indexOf(find.value) !== -1) {
                  item.find = owner.fullName
                  status = !invertFind.value
                }
              })
            }
            if (status === invertFind.value) {
              item?.options.forEach(opt => {
                let tmp = [opt.value]
                if (opt?.options?.type_value.key === 'multi_select') {
                  tmp = opt.value
                }
                tmp.forEach(value => {
                  if (value && value === find.value) {
                    item.find = opt.value + ' ' + opt?.options?.options?.unitName
                    status = !invertFind.value
                  } else if (opt?.options?.options?.unitName
                    && value
                    && (value + opt?.options?.options?.unitName).toLowerCase().indexOf(find.value.replaceAll(' ', '').toLowerCase()) !== -1
                  ) {
                    item.find = opt.value + ' ' + opt?.options?.options?.unitName
                    status = !invertFind.value
                  } else if (opt?.options?.type_value.key === 'boolean' && +opt.value === 1 && opt?.options.name.toLowerCase().indexOf(find.value.toLowerCase()) !== -1) {
                    const tmp = +opt.value === 1 ? 'ДА' : 'НЕТ'
                    item.find = opt?.options.name + ' ' + tmp
                    status = !invertFind.value
                  }
                })
              })
            }
          }
          return status
        })
    })
    const getData = () => {
      loading.value = true
      const data = {
        admin: 1
      }
      getSteadsList(data)
        .then(res => {
          list.value = res.data.data
        })
        .finally(() => {
          loading.value = false
        })
    }
    const selectItem = (item) => {
      const tmp = Object.assign([], props.modelValue)
      tmp.push(item.id)
      emit('update:model-value', tmp)
    }
    const removeStead = (itemId) => {
      const tmp = Object.assign([], props.modelValue)
      const index = props.modelValue.findIndex(item => itemId === item)
      tmp.splice(index, 1)
      emit('update:model-value', tmp)
    }
    onMounted(() => {
      getData()
    })
    return {
      filteredList,
      removeStead,
      selectItem,
      selectedSteads,
      loading,
      list,
      find,
      invertFind
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
