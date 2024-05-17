<template>
  <div>
    <q-select
      :model-value="modelValue"
      outlined
      :label="label"
      :multiple="multiple"
      clearable
      :dense="dense"
      :options="options.selectOptions"
      @clear="clearValue"
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
        <div v-if="multiple" class="row items-center value-list">
          <div v-for="item in modelValue" :key="item">
            {{ item }}<span> {{ options.unitName }}</span>
          </div>
        </div>
        <div v-else class="row items-center">
          <div class="q-mr-xs">
            {{ modelValue }}
          </div>
          <div v-if="modelValue"> {{ options.unitName }}</div>
        </div>
      </template>
    </q-select>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent } from 'vue'

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
    },
    dense: {
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
    const clearValue = () => {
      if (props.multiple) {
        emit('update:model-value', [])
      } else {
        emit('update:model-value', '')
      }
    }
    return {
      setValue,
      clearValue
    }
  }
})
</script>

<style scoped lang='scss'>
.value-list div:not(:last-child):after {
  content: ', ';
  margin-right: 5px;
}
</style>
