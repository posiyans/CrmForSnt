<template>
  <div>
    <q-card
      flat
    >
      <q-card-section class="q-pa-none">
        <q-tabs
          v-model="tab"
          align="left"
          class="text-teal"
          :breakpoint="0"
          @update:model-value="setTab"
        >
          <q-tab name="steadInfo" label="Данные" />
          <q-tab name="readings" label="Показания" />
          <q-tab v-if="bookkeeping" name="payment" label="Счета" />
        </q-tabs>
        <q-tab-panels v-model="tab" animated>
          <q-tab-panel name="steadInfo" class="ba b--dark-green" style="min-height: 250px;">
            <SteadTab :stead-id="steadId" />
          </q-tab-panel>
          <q-tab-panel name="readings" class="ba b--dark-green relative-position" style="min-height: 250px;">
            <AddInstrumentReading :stead-id="steadId" @success="reloadReading" class="absolute-top-right" style="top: 15px; right: 18px;" />
            <InstrumentReadingList :key="keyReading" :edit="readingEdit" :stead-id="steadId" @success="reloadReading" />
          </q-tab-panel>
          <q-tab-panel v-if="bookkeeping" name="payment" class="ba b--dark-green q-pa-none q-pa-sm-sm" style="min-height: 50vh;">
            <PaymentAndInvoiceForStead :stead-id="steadId" />
          </q-tab-panel>
        </q-tab-panels>
      </q-card-section>
    </q-card>
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, onMounted, ref } from 'vue'
import SteadTab from './components/SteadTab/index.vue'
import { useRoute, useRouter } from 'vue-router'
import { getSteadInfo } from 'src/Modules/Stead/api/stead'
import { usePrimaryStore } from 'stores/parimary-store'
import PaymentAndInvoiceForStead from 'src/Modules/Bookkeeping/components/PaymentAndInvoiceForStead/index.vue'
import { useAuthStore } from 'src/Modules/Auth/store/useAuthStore'
import InstrumentReadingList from 'src/Modules/MeteringDevice/components/InstrumentReadingList/index.vue'
import AddInstrumentReading from 'src/Modules/MeteringDevice/components/AddInstrumentReading/index.vue'

export default defineComponent({
  components: {
    SteadTab,
    PaymentAndInvoiceForStead,
    InstrumentReadingList,
    AddInstrumentReading
  },
  props: {},
  setup(props, { emit }) {
    const route = useRoute()
    const router = useRouter()
    const tab = ref(route.query.tab || 'steadInfo')
    const keyReading = ref(1)
    const stead = ref({})
    const steadId = ref(route.params.id)
    const primaryStore = usePrimaryStore()
    const authStore = useAuthStore()
    const bookkeeping = computed(() => {
      return authStore.checkPermission(['payment-show', 'payment-edit', 'invoice-show', 'invoice-edit', 'bookkeeping-show'])
    })
    const readingEdit = computed(() => {
      return authStore.checkPermission(['instrument_reading-edit'])
    })
    const getData = () => {
      const data = {
        id: steadId.value,
        full: 1
      }
      getSteadInfo(data)
        .then(res => {
          stead.value = res.data.data
          primaryStore.setPageName('Участок № ' + stead.value.number)
        })
    }
    onMounted(() => {
      getData()
    })
    const reloadReading = () => {
      keyReading.value++
    }
    const setTab = (val) => {
      router.replace({ path: route.fullPath, query: { tab: val } })
    }
    return {
      tab,
      setTab,
      keyReading,
      readingEdit,
      reloadReading,
      bookkeeping,
      steadId
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
