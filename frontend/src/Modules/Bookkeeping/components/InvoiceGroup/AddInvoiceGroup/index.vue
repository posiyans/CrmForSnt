<template>
  <div>
    <div>
      <q-btn label="Добавить" color="primary" @click="showDialog" />
    </div>
    <q-dialog
      v-model="dialogVisible"
      full-height
      full-width
      @hide="close"
    >
      <q-card>
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Выставить счета</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>
        <q-card-section>
          <InvoiceForm @success="success" />
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import InvoiceForm from './InvoiceForm.vue'

export default defineComponent({
  components: {
    InvoiceForm
  },
  props: {},
  setup(props, { emit }) {
    const data = ref(false)
    const dialogVisible = ref(false)
    const showDialog = () => {
      dialogVisible.value = true
    }
    const success = () => {
      dialogVisible.value = false
    }
    const close = () => {
      dialogVisible.value = false
      emit('close')
    }
    return {
      data,
      showDialog,
      success,
      close,
      dialogVisible
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
