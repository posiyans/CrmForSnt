<template>
  <div>
    <div @click="showDialog">
      <slot>
        <q-btn icon="edit" flat size="sm" color="primary" />
      </slot>
    </div>
    <q-dialog v-model="dialogVisible" persistent>
      <q-card style="min-width: 450px;">
        <q-card-section class="q-pb-none">
          <div class="row items-center">
            <div class="text-h6">Редактировать {{ newRate.name }}</div>
            <q-space />
          </div>
          <div class="text-grey text-small-80">
            {{ newRate.description }}
          </div>
        </q-card-section>
        <q-card-section>
          <div>
            <InputNumber v-model="newRate.rate.ratio_a" :label="rateLabel" outlined @update:model-value="changeRate" />
          </div>
          <div v-if="newRate.depends === 1 || newRate.depends === 3">
            <InputNumber v-model="newRate.rate.ratio_b" label="Тариф на 1 участок" outlined @update:model-value="changeRate" />
          </div>
          <div>
            <q-input v-model="newRate.rate.description" readonly label="Описание оплаты" outlined hint="Если участок есть в списке" :hide-hint="!newRate.selected.enable" />
          </div>
          <div v-if="newRate.depends === 3">
            <q-checkbox
              v-model="newRate.selected.enable"
              label="Выборочно для участков"
              @update:model-value="setSelect"
            />
            <div v-if="newRate.selected.enable">
              <div>
                <div class="q-pa-sm text-primary">
                  Выбор участков
                </div>
                <div class="row q-col-gutter-sm overflow-hidden">
                  <transition-group
                    enter-active-class="animated backInUp"
                    leave-active-class="animated backOutDown"
                  >
                    <div v-for="item in steadsObject" :key="item.id">
                      <q-chip
                        outline
                        square
                        color="primary"
                        text-color="white"
                        removable
                        @remove="removeStead(item.id)"
                      >
                        {{ item.number }}
                      </q-chip>
                    </div>
                  </transition-group>
                </div>
                <AdvancedSelectedStead
                  v-model="steads"
                  label="Найти участки"
                  selected
                  outlined
                  dense
                />
              </div>
            </div>
          </div>

          <div class="flex q-pt-md">
            <div>
              <q-btn icon="delete" color="negative" flat @click="deleteRate" />
            </div>
            <q-space />
            <div>
              <q-btn label="Ok" color="secondary" @click="closeDialog" />
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
import EditRateForm from './EditForm.vue'
import InputNumber from 'src/Modules/Rate/components/EditRate/InputNumberFloat.vue'
import { useSteadsList } from 'src/Modules/Stead/hooks/useSteadList'
import AdvancedSelectedStead from 'src/Modules/Stead/components/AdvancedSelectedStead/index.vue'

export default defineComponent({
  components: {
    EditRateForm,
    AdvancedSelectedStead,
    InputNumber
  },
  props: {
    modelValue: {
      type: Object,
      required: true
    }
  },
  setup(props, { emit }) {
    const { steadsObject, steads } = useSteadsList()
    const removeStead = (steadId) => {
      steads.value.splice(steads.value.findIndex(item => steadId === item), 1)
    }
    const rateLabel = computed(() => {
      if (newRate.value.depends === 2) {
        return 'Тариф на 1 ' + newRate.value.rate.unit_name
      } else if (newRate.value.depends === 1 || newRate.value.depends === 3) {
        return 'Тариф на 1 сотку'
      } else {
        return "Тариф"
      }
    })
    const data = ref(false)
    const newRate = ref({
      rate: {}
    })
    const dialogVisible = ref(false)
    const showDialog = () => {
      newRate.value = Object.assign({}, props.modelValue)
      if (!newRate.value.selected) {
        newRate.value.selected = {
          enable: false,
          steads: []
        }
      }
      steads.value = props.modelValue.selected.steads
      console.log(newRate.value)
      dialogVisible.value = true
    }
    const success = () => {
      dialogVisible.value = false
      emit('success')
    }
    const changeRate = () => {
      if (newRate.value.depends === 2) {
        newRate.value.rate.description = newRate.value.rate.ratio_a + ' руб*' + newRate.value.unit_name
      } else if (newRate.value.depends === 1 || newRate.value.depends === 3) {
        let text = ''
        if (newRate.value.rate.ratio_a > 0) {
          text += newRate.value.rate.ratio_a + ' руб с сотки'
        }
        if (newRate.value.rate.ratio_b > 0) {
          if (newRate.value.rate.ratio_a > 0) {
            text += ' и '
          }
          text += newRate.value.rate.ratio_b + ' руб с участка'
        }
        newRate.value.rate.description = text
      } else {
        newRate.value.rate.description = ''
      }

    }
    const cancel = () => {
      dialogVisible.value = false
    }
    const closeDialog = () => {
      console.log(steads.value)
      if (newRate.value.selected?.enable) {
        newRate.value.selected.steads = steads.value
      }
      dialogVisible.value = false
    }
    const setSelect = (val) => {
      newRate.value.selected.enable = val
    }
    const deleteRate = () => {
      emit('deleteRate')
    }
    return {
      deleteRate,
      closeDialog,
      setSelect,
      rateLabel,
      steadsObject,
      removeStead,
      steads,
      data,
      changeRate,
      newRate,
      cancel,
      success,
      showDialog,
      dialogVisible
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
