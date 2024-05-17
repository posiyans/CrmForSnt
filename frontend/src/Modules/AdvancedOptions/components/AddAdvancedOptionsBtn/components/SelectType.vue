<template>
  <div>
    <div>
      <q-input
        :model-value="modelValue.name"
        outlined
        label="Название поля"
        :rules="[required]"
        @update:model-value="setValue"
      />
    </div>
    <div>
      <q-input
        :model-value="modelValue.options.unitName"
        outlined
        hint="Оставить пустым если нет"
        label="Единица измерения"
        @update:model-value="setUnit"
      />
    </div>
    <div class="q-pa-md bg-grey-2">
      <div class="text-small-80 o-80">
        Список выбора
      </div>
      <div class="inline-block" style="min-width: 250px;">
        <div v-for="(item, index) in modelValue.options.selectOptions" :key="item" class="row items-center flex-nowrap">
          <div class="q-mr-md">
            {{ index + 1 }}. {{ item }} {{ modelValue.options.unitName }}
          </div>
          <q-space />
          <div>
            <q-btn icon="delete" flat color="red" size="sm" @click="deleteItem(index)" />
          </div>
        </div>
      </div>
      <div>
        <q-input
          v-model="newItem"
          label="Добавить"
          dense
          outlined
          @keydown.enter="addIdem"
        >
          <template v-slot:append>
            <q-btn icon="add" flat size="sm" @click="addIdem" />
          </template>
        </q-input>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent, onMounted, ref } from 'vue'
import { required } from 'src/utils/validators.js'

export default defineComponent({
  components: {},
  props: {
    modelValue: {
      type: Object,
      default: () => {
      }
    },
    multiple: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const newItem = ref('')
    const setValue = (val) => {
      const tmp = Object.assign({}, props.modelValue)
      tmp.name = val
      emit('update:model-value', tmp)
    }
    const setDefaultValue = (val) => {
      const tmp = Object.assign({}, props.modelValue)
      tmp.options.defaultValue = val
      emit('update:model-value', tmp)
    }
    const setUnit = (val) => {
      const tmp = Object.assign({}, props.modelValue)
      tmp.options.unitName = val
      emit('update:model-value', tmp)
    }
    onMounted(() => {
      const tmp = Object.assign({}, props.modelValue)
      tmp.options = {
        selectOptions: [],
        unitName: ''
      }
      emit('update:model-value', tmp)
    })
    const addIdem = () => {
      if (newItem.value) {
        const tmp = Object.assign({}, props.modelValue)
        tmp.options.selectOptions.push(newItem.value)
        emit('update:model-value', tmp)
        newItem.value = ''
      }
    }
    const deleteItem = (index) => {
      const tmp = Object.assign({}, props.modelValue)
      tmp.options.selectOptions.splice(index, 1)
      emit('update:model-value', tmp)
    }
    return {
      newItem,
      setUnit,
      addIdem,
      deleteItem,
      setValue,
      setDefaultValue,
      required
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
