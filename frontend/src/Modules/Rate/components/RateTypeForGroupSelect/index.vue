<template>
  <div>
    <q-select
      :model-value="modelValue"
      :options="options"
      :label="label"
      :loading="loading"
      map-options
      :clearable="clearable"
      :dense="dense"
      :outlined="outlined"
      :disable="disable"
      emit-value
      transition-show="jump-up"
      transition-hide="jump-up"
      option-label="name"
      option-value="id"
      @update:model-value="setValue"
      @clear="setValue('')"
      :rules="rules"
    />
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, onMounted, ref, watch } from 'vue'
import { getRateListForGroup } from 'src/Modules/Rate/api/rateAdminApi'

export default defineComponent({
  components: {},
  props: {
    modelValue: {
      type: [String, Number],
      required: true
    },
    rateGroup: {
      type: [String, Number],
      required: true
    },
    label: {
      type: String,
      default: 'Тип'
    },
    clearable: {
      type: Boolean,
      default: false
    },
    outlined: {
      type: Boolean,
      default: false
    },
    dense: {
      type: Boolean,
      default: false
    },
    disable: {
      type: Boolean,
      default: false
    },
    autoSelect: {
      type: Boolean,
      default: false
    },
    readOnly: {
      type: Boolean,
      default: false
    },
    rules: {
      type: Array,
      default: () => []
    },
    params: {
      type: Object,
      default: () => {
      }
    }
  },
  setup(props, { emit }) {
    const options = ref([])
    const loading = ref(false)
    const getData = () => {
      if (props.rateGroup) {
        loading.value = true
        getRateListForGroup(props.rateGroup)
          .then(response => {
            options.value = response.data.data
            if (!props.modelValue && props.autoSelect && options.value.length === 1) {
              setValue(options.value[0].id)
            }
            // todo добавить проверку текущего значения есть или нет он в селекте
          })
          .finally(() => {
            loading.value = false
          })
      } else {
        options.value = []
        setValue('')
      }
    }
    const setValue = (val) => {
      emit('update:model-value', val)
    }
    watch(
      () => props.rateGroup,
      () => getData()
    )
    onMounted(() => {
      getData()
    })
    return {
      setValue,
      options,
      loading
    }
  }
})
</script>

<style scoped>

</style>
