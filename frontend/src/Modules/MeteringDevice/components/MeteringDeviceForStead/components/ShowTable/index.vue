<template>
  <div>
    <q-table
      flat bordered
      :rows="list"
      :columns="columnsFilter"
      hide-bottom
      :pagination="{ rowsPerPage: 0 }"
      wrap-cells
      separator="cell"
      row-key="id"
    >
      <template v-slot:body-cell-rate="props">
        <q-td :props="props" :class="{ 'o-60': !props.row.active }">
          <div :class="{ 'text-grey': !props.row.active }">
            {{ props.row.rate.group_name }} {{ props.row.rate.name }}
          </div>
          <div v-if="!props.row.active" class="text-red">
            Не активный
          </div>
        </q-td>
      </template>
      <template v-slot:body-cell-device="props">
        <q-td :props="props" :class="{ 'o-60': !props.row.active }">
          <div class="text-weight-bold xs">
            <div :class="{ 'text-grey': !props.row.active }">
              {{ props.row.rate.group_name }} {{ props.row.rate.name }}
            </div>
            <div v-if="!props.row.active" class="text-red">
              Не активный
            </div>
          </div>
          <div>
            {{ props.row.device_brand }}
            <span class="text-primary">
              Sn: {{ props.row.serial_number }}
            </span>
          </div>
          <div class="row items-center q-col-gutter-xs justify-center text-grey">
            <div v-if="props.row.installation_date">
              с
            </div>
            <ShowTime :time="props.row.installation_date" format="DD-MM-YYYY" />
            <div v-if="props.row.verification_date">
              по
            </div>
            <ShowTime :time="props.row.verification_date" format="DD-MM-YYYY" />
          </div>
        </q-td>
      </template>
      <template v-slot:body-cell-init_value="props">
        <q-td :props="props" :class="{ 'o-60': !props.row.active }">
          {{ props.row.initial_data }} {{ props.row.rate.unit_name }}
        </q-td>
      </template>
      <template v-slot:body-cell-last_value="props">
        <q-td :props="props" :class="{ 'o-60': !props.row.active }">
          <div v-if="props.row.last_reading">
            <div>
              {{ props.row.last_reading.value }} {{ props.row.rate.unit_name }}
            </div>
            <div class="row items-center q-col-gutter-xs text-grey justify-center">
              <div>
                от
              </div>
              <ShowTime :time="props.row.last_reading.created_at" format="DD-MM-YYYY" class="text-grey" />
            </div>
          </div>
        </q-td>
      </template>
      <template v-slot:body-cell-desc="props">
        <q-td :props="props" :class="{ 'o-60': !props.row.active }">
          <div class="ellipsis">
            {{ props.row.description }}
          </div>
        </q-td>
      </template>
      <template v-slot:body-cell-actions="props">
        <q-td :props="props" :class="{ 'o-60': !props.row.active }">
          <div class="row items-center q-col-gutter-xs">
            <div>
              <q-btn color="secondary" label="Подать показания" />
            </div>
            <div v-if="edit" class="q-gutter-sm">
              <MeteringDeviceEdit :device="props.row" @close="reload" />
            </div>
          </div>
        </q-td>
      </template>
    </q-table>
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, ref } from 'vue'
import ShowTime from 'components/ShowTime/index.vue'
import MeteringDeviceEdit from 'src/Modules/MeteringDevice/components/MeteringDeviceEdit/Dialog.vue'
import { useQuasar } from 'quasar'

export default defineComponent({
  components: {
    ShowTime,
    MeteringDeviceEdit
  },
  props: {
    list: {
      type: Array,
      default: () => []
    },
    edit: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const data = ref(false)
    const $q = useQuasar()
    const columnsFilter = computed(() => {
      if ($q.screen.xs) {
        return columns.value.filter(item => {
          return !item.hideMobile
        })
      }
      return columns.value
    })
    const columns = ref([
      {
        name: 'rate',
        align: 'center',
        label: 'Тип',
        hideMobile: true
      },
      {
        name: 'device',
        align: 'center',
        label: 'Прибор'
      },
      {
        name: 'init_value',
        align: 'center',
        label: 'Начальные показания',
        hideMobile: true
      },
      {
        name: 'last_value',
        align: 'center',
        label: 'Последние показания'
      }
    ])
    const reload = () => {
      emit('reload')
    }
    return {
      data,
      columnsFilter,
      reload,
      columns
    }
  }
})
</script>

<style scoped lang='scss'>

</style>

