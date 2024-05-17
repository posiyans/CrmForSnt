<template>
  <div style="max-width: 500px;">
    <SelectStead v-model="stead_id" outlined auto-select label="Укажите номер участка" class="q-mb-sm" style="min-width: 300px;" />
    <RateGroupSelect
      v-model="rateGroupId"
      outlined
      auto-select
    />
    <div class="text-center q-pa-md" style="min-height: 150px;">
      <div v-if="stead_id" class="text-red q-pa-sm">
        <div>
          Внимание! Проверте данные.
        </div>
        <div class="row items-center justify-center">
          Участок №
          <SteadInfo :stead-id="stead_id" class="text-weight-bold q-px-sm text-primary" />
          размер
          <SteadInfo :stead-id="stead_id" format="s" class="text-weight-bold q-px-sm text-primary" />
          кв.м.
        </div>
      </div>
    </div>
    <div class="text-center q-gutter-sm">
      <q-btn color="negative" flat label="Отмена" v-close-popup />
      <q-btn color="primary" :disabled="!stead_id || !rateGroupId" label="Скачать" @click="download" />
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import { getReceiptForStead } from 'src/Modules/Receipt/api/receipt.js'
import SelectStead from 'src/Modules/Stead/components/SelectStead/index.vue'
import RateList from 'src/Modules/Rate/components/ShowRateList/index.vue'
import SteadInfo from 'src/Modules/Stead/components/ShowSteadInfo/index.vue'
import RateGroupSelect from 'src/Modules/Rate/components/RateGroupSelect/index.vue'
import DownloadFileBtn from 'src/Modules/Files/components/DownloadFileBtn/index.vue'
import { useDownloadFile } from 'src/Modules/Files/use/downloadFile'

export default defineComponent({
  components: {
    SelectStead,
    RateList,
    SteadInfo,
    RateGroupSelect,
    DownloadFileBtn
  },
  props: {},
  setup(props, { emit }) {
    const stead_id = ref('')
    const rateGroupId = ref('')
    const { downloadAndSaveFile } = useDownloadFile()
    const download = () => {
      const func = () => {
        const data = {
          rate_group_id: rateGroupId.value
        }
        return getReceiptForStead(stead_id.value, data)
      }
      downloadAndSaveFile(func)
    }

    return {
      stead_id,
      rateGroupId,
      download
    }
  }
})
</script>

<style scoped>

</style>
