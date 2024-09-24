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
        :multiple="options?.type_value.key === 'multi_select'"
      >
        -
      </component>
    </div>
    <div>
      <q-btn flat padding="sm" icon="save" color="green" :disable="loading" @click="addOptions" />
      <q-dialog v-model="dialogVisible" persistent>
        <q-card>
          <q-card-section class="row items-center q-pb-none">
            <div class="text-h6">Подтвердите</div>
          </q-card-section>
          <q-card-section class="row items-center">
            <span class="q-ml-sm">Изменить значение для поля {{ options.name }} ?</span>
          </q-card-section>

          <q-card-section class="q-pa-none text-grey">
            <q-checkbox v-model="dontAsk" label="Не спрашивать больше" size="xs" />
          </q-card-section>
          <q-card-actions align="right">
            <q-btn flat label="Отмена" color="primary" v-close-popup />
            <q-btn flat label="Сохранить" color="primary" @click="saveOptions" />
          </q-card-actions>
        </q-card>
      </q-dialog>
    </div>
  </div>

</template>

<script>
import { computed, defineComponent, ref } from 'vue'
import { addAdvancedOptionsValue } from 'src/Modules/AdvancedOptions/api/advancedOptionsApi'
import StringType from './components/StringType.vue'
import BooleanType from './components/BooleanType.vue'
import SelectType from './components/SelectType.vue'
import { errorMessage } from 'src/utils/message'
import { useAdvancedOptions } from 'src/Modules/AdvancedOptions/use/useAdvancedOptions'

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
    const { dontAsk } = useAdvancedOptions()
    const dialogVisible = ref(false)
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
    const saveOptions = () => {
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
    }
    const addOptions = () => {
      if (dontAsk) {
        saveOptions()
      } else {
        dialogVisible.value = true
      }
    }
    return {
      dialogVisible,
      saveOptions,
      dontAsk,
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
