<template>
  <div>
    <div v-if="stead" style="max-width: 95vw;">
      <table class="stead-info-table" style="width: 100%;">
        <TrTableBlock
          v-for="item in columns"
          :key="item.field"
          v-model="stead"
          :field="item"
          :edit="edit"
          @reload="getData"
        />
        <RosreestrDataTr v-if="stead.kadastr" :kadastr="stead.kadastr" />
        <SteadCoordinatesEdit v-if="edit" :stead="stead" @reload="getData" />
        <TrOptionsTableBlock
          v-for="item in stead.options"
          :key="item.id"
          :item="item"
          :edit="edit"
          @reload="getData"
        />
        <tr v-if="edit">
          <td>
            <AddAdvancedOptionsValueBtn
              object-name="stead"
              type="options"
              :parent-id="steadId"
              @success="getData"
            />
          </td>
          <td :colspan="edit ? 2 : 1"></td>
        </tr>
      </table>
    </div>

    <DropDownBlock
      v-if="stead?.coordinates"
      :key="key"
      show-label="Яндекс карты"
      hide-label="Яндекс карты"
    >
      <div style="height: 600px;">
        <YandexMap :stead-id="steadId" />
      </div>
    </DropDownBlock>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, onMounted, ref } from 'vue'
import { getSteadInfo } from 'src/Modules/Stead/api/stead'
import TrTableBlock from './components/TrTableBlock/index.vue'
import YandexMap from 'src/Modules/Yandex/components/YandexMap/index.vue'
import RosreestrDataTr from './components/RosreestrDataTr/index.vue'
import DropDownBlock from 'components/DropDownBlock/index.vue'
import SteadCoordinatesEdit from 'src/Modules/Stead/components/SteadCoordinatesEdit/index.vue'
import AddAdvancedOptionsValueBtn from 'src/Modules/AdvancedOptions/components/AddAdvancedOptionsValueBtn/index.vue'
import TrOptionsTableBlock from 'src/Modules/Stead/components/SteadInfoCard/components/TrOptionsTableBlock/index.vue'

export default defineComponent({
  components: {
    SteadCoordinatesEdit,
    TrTableBlock,
    YandexMap,
    RosreestrDataTr,
    DropDownBlock,
    AddAdvancedOptionsValueBtn,
    TrOptionsTableBlock
  },
  props: {
    steadId: {
      type: [Number, String],
      required: true
    },
    edit: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const columns = [
      {
        label: 'Номер участка',
        name: 'number',
        type: 'number'
      },
      {
        label: 'Размер',
        name: 'size',
        type: 'number',
        units: 'm<sup>2</sup>'
      },
      {
        label: 'Кадастровый номер',
        name: 'kadastr',
        type: 'string'
      },
    ]
    const data = ref(false)
    const key = ref(1)
    const stead = ref(null)

    const getData = () => {
      const data = {
        id: props.steadId,
        full: 1
      }
      getSteadInfo(data)
        .then(res => {
          stead.value = res.data.data
        })
        .finally(() => {
          key.value++
        })
    }
    onMounted(() => {
      getData()
    })
    return {
      data,
      key,
      getData,
      columns,
      stead
    }
  }
})
</script>

<style lang='scss'>
.stead-info-table {
  border-collapse: collapse;

  td, th {
    border: 1px solid #606266;
    padding: 5px 10px;
    text-align: center;
    color: #000000;
  }
}

</style>
