<template>
  <div class="relative-position">
    <div v-if="edit" class="absolute-top-right">
      <q-fab text-color="black" flat icon="more_horiz" direction="left">
        <DeleteOwnerBtn :owner-uid="ownerUid" @success="toOwnerList" />
      </q-fab>
    </div>
    <div v-if="admin" class="page-title">
      {{ fullName }}
    </div>
    <div>
      <q-markup-table
        flat
        bordered
        separator="cell"
        style="max-width: 95vw;"
      >
        <tbody>
        <tr v-for="item in fieldList" :key="item.name">
          <td style="max-width: 50vw;">
            <div class="ellipsis text-grey-8">
              {{ item.label }}
            </div>
          </td>
          <td>
            <FieldValueBlock v-model="owner[item.name]" :owner-uid="ownerUid" :field="item" :editable="editable" @success="getUserData" />
          </td>
        </tr>
        <tr>
          <td>
            <div class="row text-grey-8">
              <div>Участок</div>
              <q-space />
              <div v-if="editable">
                <AddSteadToOwner :owner-uid="ownerUid" @success="getUserData" />
              </div>
            </div>
          </td>
          <td>
            <div v-for="stead in steads" :key="stead.stead_id" @click="toStead(stead.stead_id)" class="cursor-pointer">
              <q-chip outline color="primary" text-color="white">
                уч. {{ stead.number }} {{ propFilter(stead.proportion) }}
              </q-chip>
            </div>
          </td>
        </tr>
        <tr v-if="admin">
          <td>
            <div class="row text-grey-8">
              <div>Пользователь</div>
            </div>
          </td>
          <td>
            <div class="row items-center justify-between">
              <div class="col-grow cursor-pointer" @click="toUser(owner.user_uid)">
                <UserNameByUid :uid="owner.user_uid" />
              </div>
              <div v-if="editable">
                <ChangeUserOwner :owner="owner" @success="getUserData" />
              </div>
            </div>
          </td>
        </tr>
        </tbody>
      </q-markup-table>
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useOwnerUserField } from 'src/Modules/Owner/hooks/useOwnerUserField'
import { useOwnerUser } from 'src/Modules/Owner/hooks/useOwnerUser'
import OwnerUserFieldValueEdit from 'src/Modules/Owner/components/OwnerUserFieldValueEdit/index.vue'
import FieldValueBlock from './components/FieldValueBlock/index.vue'
import AddSteadToOwner from 'src/Modules/Owner/components/AddSteadToOwner/index.vue'
import DeleteOwnerBtn from 'src/Modules/Owner/components/DeleteOwnerBtn/index.vue'
import ChangeUserOwner from 'src/Modules/Owner/components/ChangeUserOwner/index.vue'
import UserNameByUid from 'src/Modules/Users/components/UserNameByUid/index.vue'

export default defineComponent({
  components: {
    OwnerUserFieldValueEdit,
    FieldValueBlock,
    DeleteOwnerBtn,
    UserNameByUid,
    AddSteadToOwner,
    ChangeUserOwner
  },
  props: {
    ownerUid: {
      type: String,
      required: true
    },
    edit: {
      type: Boolean,
      default: false
    },
    admin: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const data = ref(false)
    const router = useRouter()
    const { fieldList, getListField } = useOwnerUserField()
    const { getInfo, owner, steads } = useOwnerUser()
    const editable = computed(() => {
      return props.edit
    })
    const fullName = computed(() => {
      if (owner.value.surname) {
        return owner?.value?.surname + ' ' + owner?.value?.name + ' ' + owner?.value?.middle_name
      }
      return ''
    })
    const getUserData = () => {
      getInfo(props.ownerUid)
    }
    onMounted(() => {
      getListField()
      getUserData()
    })
    const propFilter = (val) => {
      if (val < 100) {
        return '(' + val + '%)'
      }
      return ''
    }
    const toOwnerList = () => {
      router.push('/admin/owner/list')
    }
    const toUser = (uid) => {
      router.push('/admin/user/show/' + uid)
    }
    const toStead = (id) => {
      if (props.admin) {
        router.push('/admin/stead/info/' + id)
      }
    }
    return {
      data,
      toUser,
      fullName,
      toOwnerList,
      propFilter,
      getUserData,
      toStead,
      owner,
      fieldList,
      steads,
      editable
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
