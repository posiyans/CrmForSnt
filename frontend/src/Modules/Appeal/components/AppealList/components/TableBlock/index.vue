<template>
  <div>
    <q-table
      flat
      bordered
      :rows="list"
      :columns="filterColumns"
      hide-bottom
      :pagination="{ rowsPerPage: 0 }"
      wrap-cells
      separator="cell"
      row-key="id"
    >
      <template v-slot:body-cell-fio="props">
        <q-td :props="props" auto-width>
          <div class="row items-center q-col-gutter-sm no-wrap">
            <div>
              <router-link :to="`/admin/user/show/${props.row.user.uid}?tab=appeal`" class="text-primary">
                {{ props.row.user.fullName }}
              </router-link>
            </div>
            <div v-if="props.row.user.owner.uid" class="cursor-pointer">
              <router-link :to="`/admin/owner/show-info/${props.row.user.owner.uid}`">
                <q-icon name="home" flat color="secondary">
                  <q-tooltip>
                    Собственник
                  </q-tooltip>
                </q-icon>
              </router-link>
            </div>
          </div>
        </q-td>
      </template>
      <template v-slot:body-cell-title="props">
        <q-td :props="props" @click="showInfo(props.row)">
          <div class="row items-center justify-between no-wrap">
            <div>
              <div class="cursor-pointer" @click="showInfo(props.row)">
                {{ props.row.title }}
              </div>
              <ShowTime :after="` ${props.row.type.label}`" :time="props.row.created_at" format="DD-MM-YYYY" class="text-small-75 o-60" />
            </div>
            <div>
              <AppealStatusLabelById :status="props.row.status" add-color icon class="text-big-40" />
            </div>
          </div>
        </q-td>
      </template>
    </q-table>
  </div>
</template>

<script>
import { computed, defineComponent } from 'vue'
import { useRouter } from 'vue-router'
import ShowTime from 'src/components/ShowTime/index.vue'
import AppealStatusLabelById from 'src/Modules/Appeal/components/AppealStatusLabelById/index.vue'
import { useAuthStore } from 'src/Modules/Auth/store/useAuthStore'

export default defineComponent({
  components: {
    ShowTime,
    AppealStatusLabelById
  },
  props: {
    list: {
      type: Array,
      default: () => ([])
    },
    addFio: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const $router = useRouter()
    const columns = [
      {
        name: 'fio',
        align: 'center',
        label: 'ФИО'
      },
      {
        name: 'title',
        align: 'left',
        label: 'Тема'
      }
    ]

    const authStore = useAuthStore()
    const filterColumns = computed(() => {
      return columns.filter(column => {
        if (column.name === 'fio' && !props.addFio) {
          return false
        } else {
          return true
        }
      })
    })

    const showInfo = (appeal) => {
      if (authStore.user.uid === appeal.user.uid) {
        $router.push('/appeal/show/' + appeal.id)
      } else {
        $router.push('/admin/appeal/show/' + appeal.id)
      }
    }

    return {
      filterColumns,
      showInfo
    }
  }
})
</script>

<style scoped>

</style>
