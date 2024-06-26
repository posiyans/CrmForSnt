<template>
  <div style="min-width: 100px;">
    <q-table
      flat bordered
      :rows="rate"
      :columns="columns"
      hide-bottom
      :pagination="{ rowsPerPage: 0 }"
      wrap-cells
      separator="cell"
      row-key="id"
    >
      <template v-slot:header-cell-name="props">
        <q-th :props="props">
          <div class="row items-center">
            <div>
              {{ headerCellNameLabel }}
            </div>
            <EditRateType
              v-if="edit"
              add
              :rate-group-id="rateGroupId"
              @success="getData"
            >
              <q-btn icon="add" flat dense color="teal" />
            </EditRateType>
          </div>
        </q-th>
      </template>
      <template v-slot:body-cell-name="props">
        <q-td :props="props">
          <div style="max-width: calc(100vw - 220px)">
            <div>
              {{ props.row.name }}
            </div>
            <div class="text-grey text-small-80 ellipsis">
              {{ props.row.description }}
            </div>
          </div>
          <div v-if="edit" class="absolute-top-right">
            <EditRateType
              :rate="props.row"
              @success="getData"
            >
              <q-btn icon="more_horiz" flat dense color="grey" />
            </EditRateType>
          </div>
        </q-td>
      </template>
      <template v-slot:body-cell-rate="props">
        <q-td :props="props" style=" min-width: 150px;">
          <div v-if="props.row.rate">
            <div>
              {{ props.row.rate?.description }}
            </div>
            <div v-if="props.row.rate?.date_start" class="text-grey text-small-80 row items-center q-col-gutter-xs justify-center">
              <div>
                от
              </div>
              <ShowTime :time="props.row.rate?.date_start" format="DD-MM-YYYY" />
            </div>
          </div>
          <EditRate
            v-if="edit"
            :rate="props.row"
            @success="getData"
            class="absolute-top-right"
          >
            <q-btn icon="more_horiz" flat dense color="grey" />
          </EditRate>
        </q-td>
      </template>
      <template v-slot:body-cell-status="props">
        <q-td :props="props">
          <q-chip square :color="props.row.enable ? 'teal' : 'red'" outline text-color="white">
            {{ props.row.enable ? 'Действующий' : 'Не действующий' }}
          </q-chip>
        </q-td>
      </template>
    </q-table>
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, onMounted, ref } from 'vue'
import { getRateListForGroup } from 'src/Modules/Rate/api/rateAdminApi'
import ShowTime from 'components/ShowTime/index.vue'
import EditRate from 'src/Modules/Rate/components/EditRate/index.vue'
import EditRateType from 'src/Modules/Rate/components/EditRateType/index.vue'


export default defineComponent({
  components: {
    ShowTime,
    EditRate,
    EditRateType
  },
  props: {
    rateGroupId: {
      type: [String, Number],
      required: true
    },
    edit: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const rate = ref([])
    const headerCellNameLabel = computed(() => {
      if (props.edit) {
        return 'Назначение платежа'
      } else {
        return 'Название'
      }
    })
    const columns = [
      {
        name: 'name',
        align: 'left',
        label: 'Назначение платежа',
      },
      {
        name: 'rate',
        align: 'center',
        label: 'Тариф',
      }
    ]
    const getData = () => {
      getRateListForGroup(props.rateGroupId)
        .then(res => {
          rate.value = res.data.data
        })
    }
    onMounted(() => {
      getData()
    })
    return {
      rate,
      getData,
      headerCellNameLabel,
      columns
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
