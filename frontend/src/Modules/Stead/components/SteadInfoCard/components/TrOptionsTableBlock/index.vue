<template>
  <tr>
    <td>
      {{ item.options.name }}
    </td>
    <td>
      <div class="row items-center q-col-gutter-sm justify-center">
        <div v-if="!showEdit">
          <AdvancedOptionsShowValue :item="item" />
        </div>
        <EditAdvancedOptionsValueForm
          v-if="showEdit"
          :option="item"
          @success="reload"
        />
      </div>
    </td>
    <td v-if="edit">
      <q-btn :color="showEdit ? 'negative' : 'primary'" flat :icon="showEdit ? 'close' : 'edit'" @click="editField" />
    </td>
  </tr>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import InputAndSaveProxy from 'components/Input/InputAndSaveProxy/index.vue'
import { errorMessage } from 'src/utils/message'
import EditAdvancedOptionsValueForm from 'src/Modules/AdvancedOptions/components/EditAdvancedOptionsValueForm/index.vue'
import AdvancedOptionsShowValue from 'src/Modules/AdvancedOptions/components/AdvancedOptionsShowValue/index.vue'

export default defineComponent({
  components: {
    InputAndSaveProxy,
    EditAdvancedOptionsValueForm,
    AdvancedOptionsShowValue
  },
  props: {
    item: {
      type: Object,
      required: true
    },
    edit: {
      type: Boolean,
      default: false
    },
  },
  setup(props, { emit }) {
    const showEdit = ref(false)
    const editField = () => {
      showEdit.value = !showEdit.value
    }
    const reload = () => {
      showEdit.value = false
      emit('reload')
    }
    const errors = (er) => {
      errorMessage(er.data.errors)
    }

    return {
      showEdit,
      errors,
      reload,
      editField
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
