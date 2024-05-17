<template>
  <div class="q-pa-md">
    <q-form
      class="q-gutter-md"
      @submit="onSubmit"
    >
      <q-input
        outlined
        v-model="form.name"
        label="Название СНТ"
      />
      <q-input
        outlined
        v-model="form.full_name"
        label="Полное название"
      />
      <q-input
        outlined
        v-model="form.PersonalAcc"
        label="Счет"
      />

      <q-input
        outlined
        v-model="form.BankName"
        label="Банк"
      />

      <q-input
        outlined
        v-model="form.BIC"
        label="БИК"
      />

      <q-input
        outlined
        v-model="form.CorrespAcc"
        label="Корсчет"
      />
      <q-input
        outlined
        v-model="form.PayeeINN"
        label="ИНН"
      />
      <div>
        <q-btn label="Отмена" type="reset" color="negative" flat class="q-ml-sm" />
        <q-btn label="Сохранить" type="submit" color="primary" />
      </div>
    </q-form>
    <div class="row items-center q-col-gutter-sm text-grey">
      <div>
        обновлено
      </div>
      <ShowTime :time="form.updated_at" />
    </div>

  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, onMounted, ref } from 'vue'
import { getGardeningInfo, updateGardeningInfo } from 'src/Modules/Gardening/api/gardening'
import ShowTime from 'components/ShowTime/index.vue'
import { useQuasar } from 'quasar'


export default defineComponent({
  components: {
    ShowTime
  },
  props: {},
  setup(props, { emit }) {
    const form = ref({
      name: '',
      full_name: '',
      PersonalAcc: '',
      BankName: '',
      BIC: '',
      CorrespAcc: '',
      PayeeINN: ''
    })

    const getData = () => {
      getGardeningInfo()
        .then(response => {
          form.value = response.data
        })
    }
    const $q = useQuasar()
    const onSubmit = () => {
      updateGardeningInfo(form.value)
        .then(res => {
          getData()
          $q.notify({
            message: 'Данные успешно обновлены',
            color: 'secondary'
          })
        })
    }
    onMounted(() => {
      getData()
    })
    return {
      form,
      onSubmit
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
