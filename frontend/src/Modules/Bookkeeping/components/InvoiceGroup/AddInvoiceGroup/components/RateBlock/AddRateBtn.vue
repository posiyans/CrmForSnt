<template>
  <div>
    <q-btn icon="add" color="primary" flat size="sm" @click="showDialog" />
    <q-dialog v-model="dialogVisible" transition-show="flip-down" transition-hide="flip-up">
      <q-card>
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Добавить статью расходов</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-card-section>
          <div>
            <q-input v-model="data.name" outlined label="Название" place />
            <q-input v-model="data.description" outlined label="Назначение платежа" />
          </div>
        </q-card-section>
        <q-card-actions align="right">
          <q-btn flat label="Отмена" color="negative" v-close-popup />
          <q-btn label="Добавить" color="primary" @click="addRate" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'

export default defineComponent({
  components: {},
  props: {},
  setup(props, { emit }) {
    const data = ref({
      description: 'Членский взнос 2',
      name: 'Оплата членского взноса 2',
      depends: 1,
      selected: {
        enable: false,
        steads: []
      },
      rate: {
        ratio_a: 0,
        ratio_b: 0,
        description: '',
      }
    })
    const dialogVisible = ref(false)
    const showDialog = () => {
      dialogVisible.value = true
    }

    const addRate = () => {
      emit('add-rate', data.value)
      dialogVisible.value = false
    }
    return {
      data,
      addRate,
      showDialog,
      dialogVisible
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
