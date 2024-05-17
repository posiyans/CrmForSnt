<template>
  <div>
    <div class="inline-block" @click="showDialog">
      <slot>
        <q-btn icon="add" color="primary" flat />
      </slot>
    </div>
    <q-dialog
      v-model="dialogVisible"
      full-width
      full-height
      @hide="hideDialog"
    >
      <q-card>
        <q-card-section>
          <div class="text-h6">{{ dialogTitle }}</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
          <div class="q-mb-sm">
            <q-select
              v-model="options"
              label="Выбирете поле"
              :options="list"
              outlined
              map-options
              option-value="id"
              option-label="name"
            />
          </div>
          <div>
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
        </q-card-section>

        <q-card-actions align="right">
          <q-btn size="md" label="Отмена" color="negative" flat v-close-popup />
          <q-btn size="md" label="Сохранить" color="primary" @click="addOptions" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
import { computed, defineComponent, onMounted, ref } from 'vue'
import { addAdvancedOptionsValue, getAdvancedOptionsList } from 'src/Modules/AdvancedOptions/api/advancedOptionsApi'
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
    parentId: {
      type: [String, Number],
      required: true
    }

  },
  setup(props, { emit }) {
    const $q = useQuasar()
    const componentName = computed(() => {
      if (options.value?.type_value.key === 'string') {
        return StringType
      } else if (options.value?.type_value.key === 'boolean') {
        return BooleanType
      } else if (options.value?.type_value.key === 'select') {
        return SelectType
      } else if (options.value?.type_value.key === 'multi_select') {
        return SelectType
      }
      return 'div'
    })
    const dialogVisible = ref(false)
    const options = ref(null)
    const newOptionsValue = ref('')
    const showDialog = () => {
      options.value = null
      dialogVisible.value = true
    }
    const hideDialog = () => {
      emit('success')
    }

    const addOptions = () => {
      $q.dialog({
        title: 'Подтвердите',
        message: 'Сохранить значение для поля ' + options.value.name + '?',
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
        dialogVisible.value = false
        const data = {
          parent_id: props.parentId,
          value: newOptionsValue.value
        }
        addAdvancedOptionsValue(options.value.id, data)
          .then(() => {
            emit('success')
            dialogVisible.value = false
          })
          .catch(er => {
            errorMessage(er.response.data.errors)
          })
      })
    }
    const list = ref(false)
    const getData = () => {
      const data = {
        object: props.objectName,
        type: props.type
      }
      getAdvancedOptionsList(data)
        .then(res => {
          list.value = res.data.data
        })
    }
    onMounted(() => {
      getData()
    })
    return {
      list,
      newOptionsValue,
      showDialog,
      hideDialog,
      dialogVisible,
      options,
      addOptions,
      componentName
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
