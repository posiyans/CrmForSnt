<template>
  <div>
    <q-fab-action color="amber" text-color="black" @click="showDialog" icon="edit" />
    <q-dialog
      v-model="dialogVisible"
      full-width
      full-height
      @hide="hideDialog"
    >
      <q-card>
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Групповое редактирование параметра {{ option.name }}</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-card-section>
          <div>
            Для участков
          </div>
          <div class="row items-end q-pa-md q-col-gutter-md">
            <div class="col-grow">
              <q-input
                v-model="rawText"
                filled
                autogrow
                hint="Вставить список участков по 1 на строчке или через пробел"
              />
            </div>
            <div class="q-pl-lg q-pb-md">
              <q-btn label="Считать" icon="send" color="secondary" @click="parseStead" />
            </div>
          </div>

          <div v-if="steads.length > 0" class="q-pa-md">
            <div>
              <span class="text-weight-bold">
                Изменить значение
              </span>
              <span class="text-weight-bolder">
                {{ option.name }}
              </span>
            </div>
            <div class="row items-center q-col-gutter-md">
              <div>
                на
              </div>
              <component
                :is="componentName"
                :key="option.id"
                v-model="newOptionsValue"
                :label="option?.name"
                :options="option?.options"
                :multiple="option?.type_value.key === 'multi_select'"
              >
                -
              </component>
            </div>
            <div>
              Для номеров участков <span>({{ steads.length }} шт.)</span>
            </div>
            <div class="row items-center q-col-gutter-xs">
              <div v-for="(stead, index) in steads" :key="stead">
                <q-chip
                  outline
                  square
                  :color="stead.status.save ? 'secondary': 'primary'"
                  text-color="primary"
                  removable
                  @remove="removeStead(index)"
                >
                  {{ stead.number }}
                </q-chip>
              </div>
            </div>
            <div class="q-pa">
              <q-btn
                label="Сохранить"
                color="primary"
                :loading="savingData"
                @click="handle"
              />
            </div>
          </div>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, ref } from 'vue'
import StringType from 'src/Modules/AdvancedOptions/components/AddAdvancedOptionsValueBtn/components/StringType'
import BooleanType from 'src/Modules/AdvancedOptions/components/AddAdvancedOptionsValueBtn/components/BooleanType'
import SelectType from 'src/Modules/AdvancedOptions/components/AddAdvancedOptionsValueBtn/components/SelectType'
import { useSteadsList } from 'src/Modules/Stead/hooks/useSteadList'
import DecOfNum from 'components/DecOfNum/index.vue'
import { addAdvancedOptionsValue } from 'src/Modules/AdvancedOptions/api/advancedOptionsApi'
import { errorMessage } from 'src/utils/message'

export default defineComponent({
  components: {
    DecOfNum
  },
  props: {
    option: {
      type: Object,
      required: true
    }
  },
  setup(props, { emit }) {
    const savingData = ref(false)
    const { allSteads } = useSteadsList()
    let sendData = []
    const dialogVisible = ref(false)
    const steads = ref([])
    const rawText = ref('')
    const showDialog = () => {
      steads.value = []
      newOptionsValue.value = ''
      dialogVisible.value = true
    }
    const removeStead = (index) => {
      steads.value.splice(index, 1)
    }
    const newOptionsValue = ref('')
    const parseStead = () => {
      const tmp = rawText.value.replaceAll(' ', '\n').split('\n')
      let newText = []
      tmp.forEach(item => {
        if (item) {
          const find = allSteads.value.find(stead => {
            return stead.number === item
          })
          if (find) {
            find.status = {
              save: false
            }
            steads.value.push(find)
          } else {
            newText.push(item)
            errorMessage('Участок с номером ' + item + ' не найден')
          }
          rawText.value = newText.join('\n')
        }
      })
      steads.value = [...new Set(steads.value)]
    }
    const componentName = computed(() => {
      const typeValue = props.option.type_value.key || null
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
    const sendDataToServer = () => {
      const stead = sendData.shift()
      if (stead) {
        stead.status.save = true
        const data = {
          parent_id: stead.id,
          value: newOptionsValue.value
        }
        addAdvancedOptionsValue(props.option.id, data)
          .then(() => {
            stead.status.save = true
          })
          .catch(er => {
            errorMessage(er.response.data.errors)
          })
          .finally(() => {
            sendDataToServer()
          })
      } else {
        savingData.value = false
      }
    }
    const handle = () => {
      sendData = [...steads.value]
      savingData.value = true
      sendDataToServer()
    }
    const hideDialog = () => {
      emit('success')
    }
    return {
      hideDialog,
      savingData,
      rawText,
      handle,
      removeStead,
      allSteads,
      parseStead,
      steads,
      newOptionsValue,
      componentName,
      dialogVisible,
      showDialog
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
