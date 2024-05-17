<template>
  <tr class="text-small-85">
    <td>
      Координаты участка
    </td>
    <td class="text-grey-8" style="max-width: 250px;">
      <div v-if="showEdit">
        <div v-for="(item, index) in coordinates" :key="index" class="row items-center no-wrap q-col-gutter-xs">
          <div>
            {{ ++index }}.
          </div>
          <div>
            <q-input v-model.number="item.x" label="ось X" dense />
          </div>
          <div>
            <q-input v-model.number="item.y" label="ось Y" dense />
          </div>
          <div>
            <q-btn size="sm" icon="delete" color="negative" flat @click="deletePoint(item)" />
          </div>
        </div>
        <div class="row items-center no-wrap q-col-gutter-xs">
          <div class="q-ml-md">
            <q-input v-model.number="newPoint.x" label="ось X" dense />
          </div>
          <div>
            <q-input v-model.number="newPoint.y" label="ось Y" dense />
          </div>
          <div>
            <q-btn size="sm" icon="add" color="secondary" flat @click="addPoint" />
          </div>
        </div>
        <div class="text-left q-pa-md">
          <q-btn v-if="showEdit" flat padding="sm" icon="restore_page" color="red" @click="resetData" />
          <q-btn v-if="showEdit" flat padding="sm" icon="save" color="green" @click="saveData" />
        </div>
        <div class="text-left">
          Координатыы можно получить при помощи <a href="https://github.com/rendrom/rosreestr2coord">
          https://github.com/rendrom/rosreestr2coord
        </a>
        </div>
      </div>
      <div v-else class="">
        <div v-for="(item, index) in stead.coordinates" :key="index">
          {{ ++index }}. {{ item[0] }} - {{ item[1] }}
        </div>
      </div>
    </td>
    <td>
      <q-btn :color="showEdit ? 'negative' : 'primary'" flat :icon="showEdit ? 'close' : 'edit'" @click="editField" />
    </td>
  </tr>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import { updateSteadField } from 'src/Modules/Stead/api/stead'

export default defineComponent({
  components: {},
  props: {
    stead: {
      type: Object,
      required: true
    }
  },
  setup(props, { emit }) {
    const showEdit = ref(false)
    const coordinates = ref([])
    const newPoint = ref({
      x: 0,
      y: 0
    })
    const saveData = () => {
      const data = {
        field: 'coordinates',
        value: coordinates.value.map(item => {
          return [item.x, item.y]
        })
      }
      updateSteadField(props.stead.id, data)
        .then(() => {
          showEdit.value = false
          emit('reload')
        })
    }
    const editField = () => {
      showEdit.value = !showEdit.value
      resetData()
    }
    const addPoint = () => {
      coordinates.value.push({ x: newPoint.value.x, y: newPoint.value.y })
      newPoint.value.x = 0
      newPoint.value.y = 0
    }
    const deletePoint = (item) => {
      const key = coordinates.value.indexOf(item)
      coordinates.value.splice(key, 1)
    }
    const resetData = () => {
      coordinates.value = []
      props.stead.coordinates.forEach(item => {
        coordinates.value.push({
          x: item[0],
          y: item[1]
        })
      })
    }
    return {
      resetData,
      showEdit,
      saveData,
      editField,
      coordinates,
      newPoint,
      addPoint,
      deletePoint
    }
  }
})
</script>

<style scoped lang='scss'>
td, th {
  border: 1px solid #606266;
  padding: 5px 10px;
  text-align: center;
}
</style>
