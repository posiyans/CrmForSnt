<template>
  <div>
    <div v-if="loading">
      <q-spinner
        color="primary"
        size="3em"
      />
    </div>
    <div v-else>
      <div class="row q-col-gutter-sm overflow-hidden">
        <transition-group
          enter-active-class="animated backInUp"
          leave-active-class="animated backOutDown"
        >
          <div v-for="item in selectedSteads" :key="item.id">
            <q-chip
              outline
              square
              color="primary"
              text-color="white"
              removable
              @remove="removeStead(item.id)"
            >
              {{ item.number }}
            </q-chip>
          </div>
        </transition-group>
      </div>
      <div>
        <q-input v-model="find" outlined label="Найти" />
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
      {{ filteredList }}
      <q-separator />
      {{ list }}

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
    }
  },
  setup(props, { emit }) {
    const loading = ref(false)
    const find = ref('')
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
          let status = false
          if (find.value) {
            if (item?.number.toString().toLowerCase().indexOf(find.value) !== -1) {
              item.find = 'Номер: ' + item.number
              status = true
            } else {
              item?.owners?.forEach(owner => {
                if (owner.fullName.toLowerCase().indexOf(find.value) !== -1) {
                  item.find = owner.fullName
                  status = true
                }
              })
            }
            if (!status) {
              item?.options.forEach(opt => {
                let value = opt.value
                if (Array.isArray(value)) {
                  value = JSON.stringify(value)
                }
                console.log(value)
                if (value && value.toString().toLowerCase().indexOf(find.value) !== -1) {
                  item.find = opt.value
                  status = true
                }
              })
            }
          }
          return status
          // return JSON.stringify(item).toLowerCase().indexOf(find.value) !== -1
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
      find
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
