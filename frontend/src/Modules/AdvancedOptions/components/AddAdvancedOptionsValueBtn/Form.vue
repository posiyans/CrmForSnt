<template>
  <div class="row items-center">
    <div class="q-mr-md" style="min-width: 250px;">
      <component
        v-if="options?.id"
        :is="componentName"
        :key="options?.id"
        v-model="newOptionsValue"
        :label="options?.name"
        :options="options?.options"
        :multiple="options?.type_value === 'multi_select'"
      >
        -
      </component>
    </div>
    <div>
      <q-btn flat padding="sm" icon="save" color="green" :disable="loading" @click="addOptions" />
    </div>
  </div>

</template>

<script>
import { computed, defineComponent, ref } from 'vue'
import { addAdvancedOptionsValue } from 'src/Modules/AdvancedOptions/api/advancedOptionsApi'
import StringType from './components/StringType.vue'
import BooleanType from './components/BooleanType.vue'
import SelectType from './components/SelectType.vue'
import { useQuasar } from 'quasar'
import { errorMessage } from 'src/utils/message'

export default defineComponent({
  components: {
    StringType,
    BooleanType,
    SelectType
  },
  props: {
    dialogTitle: {
      type: String,
      default: 'Добавить поле'
    },
    objectName: {
      type: String,
      required: true
    },
    type: {
      type: String,
      default: ''
    },
    options: {
      type: Object,
      required: true
    },
    parentId: {
      type: [String, Number],
      required: true
    }

  },
  setup(props, { emit }) {
    const $q = useQuasar()
    const componentName = computed(() => {
      const typeValue = props.options?.type_value.key || null
      if (typeValue === 'string') {
        return StringType
      } else if (typeValue === 'boolean') {
        return BooleanType
      } else if (typeValue === 'select') {
        return SelectType
      } else if (typeValue === 'multi_select') {
        return SelectType
      }
      return 'div'
    })
    const loading = ref(false)
    const newOptionsValue = ref('')
    const hideDialog = () => {
      emit('success')
    }

    const addOptions = () => {
      $q.dialog({
        title: 'Подтвердите',
        message: 'Сохранить значение для поля ' + props.options.name + '?',
        cancel: {
          noCaps: true,
          flat: true,
          label: 'Отмена',
          color: 'negative'
        },
        ok: {
          noCaps: true,
          outline: true,
          label: 'Сохранить',
          color: 'primary'
        },
        persistent: true
      }).onOk(() => {
        loading.value = true
        const data = {
          parent_id: props.parentId,
          value: newOptionsValue.value
        }
        addAdvancedOptionsValue(props.options.id, data)
          .then(() => {
            emit('success')
          })
          .catch(er => {
            errorMessage(er.response.data.errors)
          })
          .finally(() => {
            loading.value = false
          })
      })
    }
    return {
      newOptionsValue,
      loading,
      hideDialog,
      addOptions,
      componentName
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
