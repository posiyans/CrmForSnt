<template>
  <div class="row items-center justify-center">
    <div class="q-mr-sm" style="min-width: 250px;">
      <component
        v-if="option?.id"
        :is="componentName"
        :key="option?.options?.id"
        v-model="newOptionsValue"
        :label="option?.name"
        dense
        :options="option.options?.options"
        :multiple="option?.options?.type_value.key === 'multi_select'"
      >
      </component>
    </div>
    <div>
      <q-btn-group outline>
        <q-btn flat padding="sm" icon="save" color="green" :disable="loading" @click="saveOptions" />
      </q-btn-group>
    </div>
  </div>
</template>

<script>
import { computed, defineComponent, onMounted, ref } from 'vue'
import { editAdvancedOptionsValue } from 'src/Modules/AdvancedOptions/api/advancedOptionsApi'
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
    option: {
      type: Object,
      required: true
    }
  },
  setup(props, { emit }) {
    const $q = useQuasar()
    const componentName = computed(() => {
      if (props.option.options?.type_value.key === 'string') {
        return StringType
      } else if (props.option.options?.type_value.key === 'boolean') {
        return BooleanType
      } else if (props.option.options?.type_value.key === 'select') {
        return SelectType
      } else if (props.option.options?.type_value.key === 'multi_select') {
        return SelectType
      }
      return 'div'
    })
    const loading = ref(false)
    const newOptionsValue = ref('')
    const reload = () => {
      emit('success')
    }

    const saveOptions = () => {
      $q.dialog({
        title: 'Подтвердите',
        message: 'Изменить значение для поля ' + props.option.options.name + '?',
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
        const data = {
          value: newOptionsValue.value
        }
        editAdvancedOptionsValue(props.option.id, data)
          .then(() => {
            emit('success')
          })
          .catch(er => {
            errorMessage(er.response.data.errors)
          })
      })
    }
    onMounted(() => {
      newOptionsValue.value = props.option.value
    })
    return {
      loading,
      newOptionsValue,
      reload,
      saveOptions,
      componentName
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
