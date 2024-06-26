<template>
  <div>
    <q-table
      flat bordered
      :rows="list"
      :columns="columns"
      hide-bottom
      :pagination="{ rowsPerPage: 0 }"
      wrap-cells
      separator="cell"
      row-key="fio"
      :visible-columns="visibleColumns"
    >
      <template v-slot:header="props">
        <q-tr :props="props">
          <q-th
            v-for="col in props.cols"
            :key="col.name"
            :props="props"
          >
            <div class="items-center justify-between" :class="{row: col.name === 'fio'}">
              <div>
                {{ col.label }}

              </div>
              <div
                v-if="col.name === 'fio'"
              >
                <q-select
                  v-model="visibleColumns"
                  multiple
                  outlined
                  dense
                  options-dense
                  display-value="Доп. колонки"
                  emit-value
                  map-options
                  :options="columnsHidden"
                  option-value="name"
                  options-cover
                  style="min-width: 150px"
                  @update:model-value="saveColumns"
                />
              </div>
            </div>
          </q-th>
        </q-tr>
      </template>
      <template v-slot:body-cell-fio="props">
        <q-td :props="props">
          <div class="row items-center q-col-gutter-sm text-grey-7 cursor-pointer no-wrap" @click="toUserInfo(props.row.uid)">
            <div>
              <UserAvatarByUid :uid="props.row.uid" size="35px" />
            </div>
            <div>
              <div class="row items-center q-col-gutter-xs">
                <div class="text-no-wrap ">
                  {{ props.row.id }}. {{ fullNameFilter(props.row) }}
                </div>
                <div v-if="props.row.owner" class="text-teal cursor-pointer" @click="toOwner(props.row.owner.uid)">
                  <q-icon name="home" />
                </div>
              </div>

              <div v-if="props.row.last_connect" class="text-small-80">
                <ShowTime :time="props.row.last_connect" from />
              </div>
            </div>
            <q-space />
            <div
              v-if="!visibleColumns.includes('email')"
              :class="{
                  'text-teal': props.row.email_verified_at,
                  'text-grey' : !props.row.email_verified_at
                  }"
              style="width: 20px;"
            >
              <q-icon v-if="props.row.email" name="email" class="text-big-40">
                <q-tooltip>
                  {{ props.row.email }}
                </q-tooltip>
              </q-icon>
            </div>
            <div
              v-if="!visibleColumns.includes('phone')"
              style="width: 20px;">
              <q-icon
                v-if="props.row.phone"
                name="phone"
                class="text-big-40"
              >
                <q-tooltip>
                  {{ props.row.phone }}
                </q-tooltip>
              </q-icon>
            </div>
          </div>
        </q-td>
      </template>
      <template v-slot:body-cell-phone="props">
        <q-td :props="props" class="text-grey-7">
          {{ props.row.phone }}
        </q-td>
      </template>
      <template v-slot:body-cell-email="props">
        <q-td :props="props">
                    <span
                      class="link-type"
                      :class="{
              'text-teal' : props.row.email_verified_at,
              'text-grey' : !props.row.email_verified_at
            }"
                      :title="props.row.email_verified_at ? '' : 'Не подтвержден'"
                    >
            {{ props.row.email }}</span>
        </q-td>
      </template>
    </q-table>
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, onMounted, ref } from 'vue'
import OwnerUserNameAndProportionBlock from 'src/Modules/Owner/components/OwnerUserNameAndProportionBlock/index.vue'
import { useRouter } from 'vue-router'
import UserAvatarByUid from 'src/Modules/Avatar/components/UserAvatarByUid/index.vue'
import ShowTime from 'src/components/ShowTime/index.vue'
import { LocalStorage, useQuasar } from 'quasar'

export default defineComponent({
  components: {
    OwnerUserNameAndProportionBlock,
    UserAvatarByUid,
    ShowTime
  },
  props: {
    list: {
      type: Array,
      required: true
    }
  },
  setup(props, { emit }) {
    const dialogVisible = ref(false)
    const visibleColumns = ref(['fio'])
    const router = useRouter()
    const columnsHidden = computed(() => {
      return columns.value.filter(item => item.hidden)
    })
    const columns = ref([
      {
        name: 'fio',
        align: 'left',
        label: 'ФИО',
      },
      {
        name: 'email',
        align: 'center',
        label: 'Email',
        hidden: true
      },
      {
        name: 'phone',
        align: 'center',
        label: 'Телефон',
        hidden: true
      }
    ])
    const toOwner = (uid) => {
      router.push('/admin/owner/show-info/' + uid)
    }
    const fullNameFilter = computed(() => {
      return user => {
        let result = ''
        if (user.last_name) {
          result += user.last_name
        }
        if (user.name) {
          result += ' ' + user.name
        }
        if (user.middle_name) {
          result += ' ' + user.middle_name
        }
        return result
      }
    })
    const StorageKeyName = 'UserListTableAddColumns'
    const toUserInfo = (uid) => {
      router.push('/admin/user/show/' + uid)
    }
    const saveColumns = () => {
      LocalStorage.set(StorageKeyName, visibleColumns.value)
    }
    const $q = useQuasar()
    onMounted(() => {
      if (LocalStorage.has(StorageKeyName)) {
        visibleColumns.value = LocalStorage.getItem(StorageKeyName)
      } else if ($q.screen.width > 1000) {
        visibleColumns.value.push('email')
        visibleColumns.value.push('phone')
      }
    })
    return {
      dialogVisible,
      visibleColumns,
      columnsHidden,
      toOwner,
      fullNameFilter,
      saveColumns,
      columns,
      toUserInfo
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
