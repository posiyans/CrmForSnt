<template>
  <div>
    <div @click="showDialog">
      <slot>
        <q-btn icon="add" color="primary" flat />
      </slot>
    </div>
    <q-dialog
      v-model="dialogVisible"
      full-width
      full-height
      :maximized="mobile"
      @hide="hideDialog"
    >
      <q-card>
        <q-card-section class="row items-center">
          <div class="text-h6">{{ dialogTitle }}</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-card-section class="q-pt-none">
          <div class="q-gutter-sm">
            <div>
              <q-select
                v-model="options.type_value"
                :options="typeList"
                map-options
                emit-value
                outlined
                label="Тип поля"
              />
            </div>
            <component
              :is="componentName"
              :key="options.type_value"
              v-model="options"
            >
              в разработке
            </component>
          </div>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn size="md" label="Отмена" flat color="negative" v-close-popup />
          <q-btn size="md" label="Добавить" color="primary" @click="addOptions" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
import { computed, defineComponent, ref } from 'vue'
import { addAdvancedOptions, getAdvancedOptionsType } from 'src/Modules/AdvancedOptions/api/advancedOptionsApi'
import StringType from './components/StringType.vue'
import BooleanType from './components/BooleanType.vue'
import SelectType from './components/SelectType.vue'
import { useQuasar } from 'quasar'
import { errorMessage } from 'src/utils/message.js'

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
    }
  },
  setup(props, { emit }) {
    const $q = useQuasar()
    const componentName = computed(() => {
      if (options.value.type_value === 'string') {
        return StringType
      } else if (options.value.type_value === 'boolean') {
        return BooleanType
      } else if (options.value.type_value === 'select') {
        return SelectType
      } else if (options.value.type_value === 'multi_select') {
        return SelectType
      }
      return 'div'
    })
    const dialogVisible = ref(false)
    const mobile = computed(() => {
      return $q.screen.width < 600
    })
    const typeList = ref([])
    const options = ref({
      object: '',
      type: '',
      type_value: 'string',
      name: '',
      options: {}
    })
    const showDialog = () => {
      getType()
      dialogVisible.value = true
    }
    const hideDialog = () => {
      emit('success')
    }
    const getType = () => {
      getAdvancedOptionsType()
        .then(res => {
          typeList.value = res.data.data
        })
    }
    const addOptions = () => {
      $q.dialog({
        title: 'Подтвердите',
        message: 'Добавить поле ' + options.value.name + '?',
        cancel: {
          noCaps: true,
          flat: true,
          label: 'Отмена',
          color: 'negative'
        },
        ok: {
          noCaps: true,
          outline: true,
          label: 'Добавить',
          color: 'primary'
        },
        persistent: true
      }).onOk(() => {
        options.value.object = props.objectName
        options.value.type = props.type
        addAdvancedOptions(options.value)
          .then(() => {
            emit('success')
            dialogVisible.value = false
          })
          .catch(er => {
            errorMessage(er.response.data.errors)
          })
      })
    }
    return {
      showDialog,
      hideDialog,
      typeList,
      dialogVisible,
      options,
      mobile,
      addOptions,
      componentName
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
