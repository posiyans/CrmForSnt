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
      row-key="id"
    >
      <template v-slot:header="props">
        <q-tr :props="props">
          <q-th
            v-for="col in props.cols"
            :key="col.name"
            :props="props"
            class=""
          >
            {{ col.label }}
          </q-th>
          <q-th v-for="item in showAdvancedColumns" :key="item">
            {{ option(item)?.name }}
          </q-th>
          <q-th>
            <div class="row items-center">
              <q-space />
              <SteadListTableOptions
                v-model="showAdvancedColumns"
                @update:model-value="setFields"
              />
            </div>
          </q-th>
        </q-tr>
      </template>
      <template v-slot:body="props">
        <q-tr>
          <q-td auto-width class="text-center">
            <router-link class="my-table-details" :to="`/admin/stead/info/${props.row.id}`">
              <q-chip outline square color="primary" text-color="white">
                {{ props.row.number }}
              </q-chip>
            </router-link>
          </q-td>
          <q-td auto-width class="text-center">
            <div class="my-table-details">
              {{ props.row.size }}
            </div>
          </q-td>
          <q-td>
            <div v-for="owner in props.row.owners" :key="owner.uid" class="row q-col-gutter-sm">
              <OwnerUserNameAndProportionBlock :owner="owner" class="justify-center cursor-pointer" @click="toOwner(owner.uid)" />
              <router-link v-if="owner.user_uid" class="text-grey" :to="`/admin/user/show/${owner.user_uid}`">
                <UserNameByUid :uid="owner.user_uid" before="(" after=")" />
              </router-link>
            </div>
          </q-td>
          <q-td v-for="item in showAdvancedColumns" :key="item">
            <AdvancedOptionsShowValue :item="props.row.options.find(i => i.id === item)" />
          </q-td>
          <q-td class="text-center">
            <div class="q-gutter-sm">
              <q-btn label="Инфо" color="primary" :to="`/admin/stead/info/${props.row.id}`" />
            </div>
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>

<script>
import { defineComponent, onMounted, ref } from 'vue'
import OwnerUserNameAndProportionBlock from 'src/Modules/Owner/components/OwnerUserNameAndProportionBlock/index.vue'
import { useRoute, useRouter } from 'vue-router'
import UserNameByUid from 'src/Modules/Users/components/UserNameByUid/index.vue'
import SteadListTableOptions from 'src/Modules/Stead/components/SteadListTableOptions/index.vue'
import { useAdvancedOptionsList } from 'src/Modules/AdvancedOptions/use/useAdvancedOptionsList'
import AdvancedOptionsShowValue from 'src/Modules/AdvancedOptions/components/AdvancedOptionsShowValue/index.vue'

export default defineComponent({
  components: {
    OwnerUserNameAndProportionBlock,
    UserNameByUid,
    SteadListTableOptions,
    AdvancedOptionsShowValue
  },
  props: {
    list: {
      type: Array,
      required: true
    }
  },
  setup(props, { emit }) {
    const { option, optionsList } = useAdvancedOptionsList('stead', 'options')
    const router = useRouter()
    const route = useRoute()
    const showAdvancedColumns = ref([])
    const columns = [
      {
        name: 'number',
        align: 'center',
        label: '№'
      },
      {
        name: 'size',
        align: 'center',
        label: 'Размер, кв.м'
      },
      {
        name: 'owner',
        align: 'center',
        label: 'Собственник'
      }
    ]
    const toOwner = (uid) => {
      router.push('/admin/owner/show-info/' + uid)
    }
    const setFields = (val) => {
      const oldQuery = route.query
      const query = Object.assign({}, oldQuery)
      query.fields = val
      router.replace({ path: route.path, query })
    }
    onMounted(() => {
      if (route.query.fields) {
        route.query.fields.forEach(i => {
          showAdvancedColumns.value.push(+i)
        })
      }
      // showAdvancedColumns.value = route.query.fields || []
    })
    return {
      toOwner,
      setFields,
      columns,
      option,
      optionsList,
      showAdvancedColumns
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
