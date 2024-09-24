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
        <q-btn flat padding="sm" icon="save" color="green" :disable="loading" @click="showDialog" />
        <q-dialog v-model="dialogVisible" persistent>
          <q-card>
            <q-card-section class="row items-center q-pb-none">
              <div class="text-h6">Подтвердите</div>
            </q-card-section>
            <q-card-section class="row items-center">
              <span class="q-ml-sm">Изменить значение для поля {{ option.options.name }} ?</span>
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
// import { useQuasar } from 'quasar'
import { errorMessage } from 'src/utils/message'
import { useAdvancedOptions } from 'src/Modules/AdvancedOptions/use/useAdvancedOptions'

export default defineComponent({
  components: {
    StringType,
    BooleanType,
    SelectType
  },
  props: {
    option: {
      type: Object,
      required: true
    }
  },
  setup(props, { emit }) {
    // const $q = useQuasar()
    const { dontAsk } = useAdvancedOptions()
    const dialogVisible = ref(false)
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
    const showDialog = () => {
      if (dontAsk.value) {
        saveOptions()
      } else {
        dialogVisible.value = true
      }
    }
    const saveOptions = () => {
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
    }
    onMounted(() => {
      newOptionsValue.value = props.option.value
    })
    return {
      dontAsk,
      dialogVisible,
      showDialog,
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
