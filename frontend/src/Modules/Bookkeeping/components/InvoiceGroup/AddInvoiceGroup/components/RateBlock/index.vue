<template>
  <div>
    <div class="flex items-center">
      <div class="q-pa-sm text-primary text-weight-bold">
        Начислить
      </div>
      <AddRateBtn v-if="editRate" @add-rate="addRate" />
    </div>
    <div class="row">
      <q-markup-table
        square
      >
        <tbody>
        <tr v-for="(item, index) in rateType" :key="item.id">
          <td>
            <div>
              {{ item.name }}
            </div>
            <div v-if="item.selected?.enable" class="text-small-65">
              Выборочно для
              {{ item.selected?.steads.length }}
              <DecOfNum :number="item.selected?.steads.length" :titles="['участока','участков','участков']" />
            </div>
          </td>
          <td>
            <div class="flex">
              <div>
                {{ item.rate.description }}
              </div>

            </div>
          </td>
          <td>
            <EditRate v-if="editRate" :model-value="item" @deleteRate="deleteRate(index)" />
          </td>
        </tr>
        </tbody>
      </q-markup-table>
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import EditRate from 'src/Modules/Bookkeeping/components/InvoiceGroup/AddInvoiceGroup/components/RateBlock/EditRate.vue'
import AddRateBtn from 'src/Modules/Bookkeeping/components/InvoiceGroup/AddInvoiceGroup/components/RateBlock/AddRateBtn'
import DecOfNum from 'components/DecOfNum/index.vue'

export default defineComponent({
  components: {
    EditRate,
    AddRateBtn,
    DecOfNum
  },
  props: {
    rateType: {
      type: Object,
      default: ''
    },
    editRate: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const selected = ref([])
    const rate = ref([])
    const addRate = (item) => {
      props.rateType.push(item)
    }
    const deleteRate = (index) => {
      props.rateType.splice(index, 1)
    }
    return {
      deleteRate,
      addRate,
      selected,
      rate
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
