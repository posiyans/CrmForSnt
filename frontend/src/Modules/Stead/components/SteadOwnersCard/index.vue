<template>
  <div class="relative-position" style="min-height: 150px;">
    <div v-if="edit" class="absolute-top-right">
      <q-btn color="primary" icon="add" flat :to="'/admin/owner/add?stead_id=' + stead.id" />
    </div>
    <table v-if="stead" :class="{ 'text-red': proportionErrors }">
      <tr v-for="(owner, index) in stead?.owners" :key="owner.uid">
        <td class="text-black">{{ ++index }}</td>
        <td>
          <div class="row items-center q-col-gutter-sm justify-between">
            <div>
              {{ owner.fullName }}
            </div>
            <ProportionBlock v-if="edit" :owner="owner" @success="getData" />
            <div v-else>
              <q-chip
                square
              >
                {{ owner.proportion }}%
              </q-chip>
            </div>
          </div>
        </td>
        <td v-if="ownerShow">
          <q-btn icon="keyboard_double_arrow_right" flat color="primary" :to="'/admin/owner/show-info/' + owner.uid" />
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, onMounted, ref } from 'vue'
import { getSteadInfo } from 'src/Modules/Stead/api/stead'
import TrTableBlock from './components/TrTableBlock/index.vue'
import ProportionBlock from './components/ProportionBlock/index.vue'
import { useAuthStore } from 'src/Modules/Auth/store/useAuthStore'

export default defineComponent({
  components: {
    TrTableBlock,
    ProportionBlock
  },
  props: {
    steadId: {
      type: [Number, String],
      required: true
    },
    edit: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const data = ref(false)
    const stead = ref({})
    const authStore = useAuthStore()
    const ownerShow = computed(() => {
      return authStore.permissions.includes('owner-show')
    })
    const proportionErrors = computed(() => {
      let count = 0;
      stead.value?.owners?.forEach(item => {
        count += item.proportion
      })
      return count !== 100
    })
    const getData = () => {
      const data = {
        id: props.steadId,
        full: 1
      }
      getSteadInfo(data)
        .then(res => {
          stead.value = res.data.data
        })
    }
    onMounted(() => {
      getData()
    })
    return {
      data,
      ownerShow,
      getData,
      proportionErrors,
      stead
    }
  }
})
</script>

<style scoped lang='scss'>
table {
  border-collapse: collapse;
}

td, th {
  border: 1px solid #606266;
  padding: 5px 10px;
  text-align: center;
}
</style>
