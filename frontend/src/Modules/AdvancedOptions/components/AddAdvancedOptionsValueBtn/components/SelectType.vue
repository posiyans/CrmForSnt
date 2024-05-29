<template>
  <div>
    <q-select
      :model-value="modelValue"
      outlined
      :label="label"
      :multiple="multiple"
      clearable
      :options="options.selectOptions"
      @update:model-value="setValue"
    >
      <template v-slot:option="scope">
        <q-item v-bind="scope.itemProps">
          <q-item-section>
            <q-item-label>{{ scope.opt }} {{ options.unitName }}</q-item-label>
          </q-item-section>
        </q-item>
      </template>
      <template v-slot:selected>
        <div class="row items-center">
          <div v-if="multiple">
            <div v-for="val in modelValue" :key="val">
              {{ val }} <span v-if="options.unitName">{{ options.unitName }}</span>
            </div>
          </div>
          <div v-else>
            <div class="q-mr-xs">
              {{ modelValue }}
            </div>
            <div v-if="modelValue"> {{ options.unitName }}</div>
          </div>
        </div>
      </template>
    </q-select>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, onMounted } from 'vue'

export default defineComponent({
  components: {},
  props: {
    modelValue: {
      type: [String, Array],
      default: ''
    },
    label: {
      type: String,
      default: undefined
    },
    options: {
      type: Object,
      default: () => {
        return {
          selectOptions: [],
          unitName: ''
        }
      }
    },
    multiple: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const setValue = (val) => {
      if (val && props.multiple) {
        val.sort()
      }
      emit('update:model-value', val)
    }
    onMounted(() => {
      if (props.multiple) {
        emit('update:model-value', [])
      } else {
        emit('update:model-value', '')
      }
    })
    return {
      setValue
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
