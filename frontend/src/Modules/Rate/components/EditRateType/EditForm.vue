<template>
  <div class="q-gutter-sm">
    <div>
      <q-input v-model="newRate.name" label="Название" outlined />
    </div>
    <div>
      <q-input v-model="newRate.description" label="Назначение платежа" outlined />
    </div>
    <div class="row">
      <div v-if="!rate.rate">
        <q-btn color="negative" label="Удалить" @click="remove" />
      </div>
      <q-space />
      <div>
        <q-btn color="negative" flat label="Отмена" @click="cancel" />
        <q-btn color="primary" :label="add ? 'Добавить' : 'Сохранить'" @click="saveData" />
      </div>
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, onMounted, ref } from 'vue'
import InputDate from 'components/Input/InputDate/index.vue'
import { createRateType, deleteRateType, updateRateType } from 'src/Modules/Rate/api/rateAdminApi'
import { errorMessage } from 'src/utils/message'
import { useQuasar } from 'quasar'

export default defineComponent({
  components: {
    InputDate
  },
  props: {
    rate: {
      type: Object,
      required: true
    },
    add: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const readonly = ref(true)
    const data = ref(false)
    const newRate = ref({})
    const $q = useQuasar()
    const cancel = () => {
      emit('cancel')
    }
    const saveData = () => {
      const data = {
        description: newRate.value.description,
        name: newRate.value.name
      }
      if (props.add) {
        data.rate_group_id = props.rate.rate_group_id
        createRateType(data)
          .then(res => {
            emit('success')
          })
          .catch(er => {
            errorMessage(er.response.data.errors)
          })
      } else {
        updateRateType(props.rate.id, data)
          .then(res => {
            emit('success')
          })
          .catch(er => {
            errorMessage(er.response.data.errors)
          })
      }
    }
    const remove = () => {
      $q.dialog({
        title: 'Подтвердите',
        message: 'Удалить ' + props.rate.name + '?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        deleteRateType(props.rate.id)
          .then(() => {
            emit('success')
          })
          .catch(er => {
            errorMessage(er.response.data.errors)
          })
      })
    }
    onMounted(() => {
      newRate.value = Object.assign({}, props.rate)
    })
    return {
      data,
      remove,
      readonly,
      cancel,
      saveData,
      newRate
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
