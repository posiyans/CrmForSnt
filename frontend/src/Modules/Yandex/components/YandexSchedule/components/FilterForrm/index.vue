<template>
  <div class="row items-center q-col-gutter-sm">
    <div>
      <q-btn-group push>
        <q-btn
          v-for="item in dates"
          :key="item.key"
          push
          :color="item.key === modelValue.type ? 'primary' : ''"
          :text-color="item.key === modelValue.type ? '' : 'black'"
          :label="item.label"
          :icon="item.icon"
          :icon-right="item.iconRight"
          @click="setType(item.key)"
        />
      </q-btn-group>
    </div>
    <div>
      <q-btn-group
        push
      >
        <q-btn
          push
          :color="modelValue.back ? 'primary' : ''"
          :text-color="modelValue.back ? '' : 'black'"
          :label="fromLabel"
          icon="arrow_back"
          @click="setDirection(true)"
        />
        <q-btn
          push
          :color="!modelValue.back ? 'primary' : ''"
          :text-color="!modelValue.back ? '' : 'black'"
          :label="toLabel"
          icon-right="arrow_forward"
          @click="setDirection(false)"
        />
      </q-btn-group>
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent } from 'vue'

export default defineComponent({
  components: {},
  props: {
    modelValue: {
      type: Object,
      required: true
    },
    toLabel: {
      type: String,
      default: 'Туда'
    },
    fromLabel: {
      type: String,
      default: 'Обратно'
    }
  },
  setup(props, { emit }) {
    const dates = [
      {
        key: 0,
        label: 'Сегодня'
      },
      {
        key: 1,
        label: 'Завтра'
      },
      {
        key: 2,
        label: 'На все дни'
      }
    ]
    const setDirection = (val) => {
      const tmp = Object.assign({}, props.modelValue)
      tmp.back = val
      emit('update:model-value', tmp)
    }
    const setType = (val) => {
      const tmp = Object.assign({}, props.modelValue)
      tmp.type = val
      emit('update:model-value', tmp)
    }
    return {
      dates,
      setDirection,
      setType
    }
  }
})
</script>

<style scoped>

</style>
