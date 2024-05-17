<template>
  <div>
    <q-list bordered>
      <template v-for="item in list" :key="item.id">
        <q-item clickable v-ripple>
          <q-item-section>
            <q-item-label>{{ item.name }}</q-item-label>
            <q-item-label caption lines="2">{{ item.type_value.label }}</q-item-label>
          </q-item-section>
          <q-item-section v-if="showCheckbox" side top>
            <q-toggle :model-value="modelValue" :val="item.id" @update:model-value="setValue" />
          </q-item-section>
        </q-item>
        <q-separator />
      </template>
    </q-list>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, onMounted, ref } from 'vue'
import { getAdvancedOptionsList } from 'src/Modules/AdvancedOptions/api/advancedOptionsApi'

export default defineComponent({
  components: {},
  props: {
    modelValue: {
      type: Array,
      default: () => []
    },
    objectName: {
      type: String,
      required: true
    },
    type: {
      type: String,
      default: ''
    },
    showCheckbox: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
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
    const setValue = (val) => {
      emit('update:model-value', val)
    }
    return {
      list,
      setValue
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
