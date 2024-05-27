<template>
  <div>
    <table class="table-reading">
      <thead>
      <tr>
        <th>
          Участок
        </th>
        <th>
          Период
        </th>
        <th>
          Прибор
        </th>
        <th>
          Показания
        </th>
        <th>
          К оплате
        </th>
        <th>
          Примечание
        </th>
      </tr>
      </thead>
      <template v-for="(item,index) in list" :key="index">
        <tbody>
        <template v-for="i in Object.keys(item)" :key="item[i].id">
          <tr>
            <td v-if="i === Object.keys(item)[0]" :rowspan="Object.keys(item).length" class="text-center cursor-pointer" @click="toStead(item[i].device.stead.id)">
              <q-chip outline square color="primary" text-color="white">
                {{ item[i].device.stead.number }}
              </q-chip>
            </td>
            <td v-if="i === Object.keys(item)[0]" :rowspan="Object.keys(item).length" class="text-center">
              {{ item[i].period }}
            </td>
            <td class="q-px-sm">
              <div>
                {{ item[i].device.rate.name }}
              </div>
              <div class="row text-small-80 o-80">
                <div class="q-mr-xs">
                  {{ item[i].device.device_brand }}
                </div>
                <div class="text-primary">
                  Sn: {{ item[i].device.serial_number }}
                </div>
              </div>
            </td>
            <td class="text-center relative-position">
              <div class="text-weight-bold text-no-wrap">
                {{ item[i].value }} {{ item[i].device.rate.unit_name }}
              </div>
              <div class="text-small-85 text-grey">
                {{ item[i].previous_value }} {{ item[i].device.rate.unit_name }}
              </div>
              <div class="absolute-top-right">
                <DeleteInstrumentReading v-if="!item[i].invoice" :reading-id="item[i].id" @success="reload" />
              </div>
            </td>
            <td class="text-center" :class="{ 'o-60': !item[i].device.active }">
              <div class="row items-center justify-center">
                <div class="q-mr-xs">
                  {{ item[i].delta }} {{ item[i].device.rate.unit_name }}
                </div>
                <div class="text-small-85 text-grey">
                  {{ item[i].rate.description }}
                </div>
              </div>
              <div>
                <ShowPrice :price="item[i].cost" class="text-primary" />
              </div>
            </td>
            <td v-if="i === Object.keys(item)[0]" :rowspan="Object.keys(item).length">
              <div class="row items-center q-pl-sm">
                <div>
                  <div v-if="item[Object.keys(item)[0]].invoice" class="cursor-pointer text-red-10">
                    <InvoiceInfo :invoice="item[Object.keys(item)[0]].invoice" :edit="edit">
                      Счет № {{ item[Object.keys(item)[0]].invoice.id }}
                    </InvoiceInfo>
                  </div>
                  <div v-if="item[Object.keys(item)[0]].payment" class="cursor-pointer text-teal">
                    <PaymentInfoShowAndEdit :payment-id="item[Object.keys(item)[0]].payment.id" :edit="edit">
                      Платеж № {{ item[Object.keys(item)[0]].payment.id }}
                    </PaymentInfoShowAndEdit>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </template>
        </tbody>
      </template>
    </table>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import ShowTime from 'components/ShowTime/index.vue'
import MeteringDeviceEdit from 'src/Modules/MeteringDevice/components/MeteringDeviceEdit/Dialog.vue'
import PaymentInfoShowAndEdit from 'src/Modules/Bookkeeping/components/Payment/PaymentInfoShowAndEdit/Dialog.vue'
import InvoiceInfo from 'src/Modules/Bookkeeping/components/Invoice/InvoiceInfo/Dialog.vue'
import ShowPrice from 'components/ShowPrice/index.vue'
import DeleteInstrumentReading from 'src/Modules/MeteringDevice/components/DeleteInstrumentReading/index.vue'
import { useRouter } from 'vue-router'

export default defineComponent({
  components: {
    ShowTime,
    MeteringDeviceEdit,
    PaymentInfoShowAndEdit,
    DeleteInstrumentReading,
    InvoiceInfo,
    ShowPrice
  },
  props: {
    list: {
      type: Array,
      default: () => []
    },
    edit: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const data = ref(false)
    const router = useRouter()
    const reload = () => {
      emit('reload')
    }
    const toStead = (id) => {
      router.push('/admin/stead/info/' + id + '?tab=readings',)
    }
    return {
      data,
      toStead,
      reload
    }
  }
})
</script>

<style scoped lang='scss'>
.table-tr-reading {

}

.table-reading {
  td, th {
    border: 1px solid rgba(0, 0, 0, 0.12);
  }

  th {
    padding: 7px 16px;
    font-weight: 500;
    font-size: 12px;
    -webkit-user-select: none;
    user-select: none;
  }

  td {
    font-size: 13px;
  }

  width: 100%;
  border-collapse: collapse;
}

tbody:hover,
tr.hover,
th.hover,
td.hover,
tr.hoverable:hover {
  background-color: #eff9ff;
}
</style>

