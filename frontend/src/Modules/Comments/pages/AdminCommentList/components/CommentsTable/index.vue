<template>
  <div>
    <transition-group
      appear
      enter-active-class="animated fadeIn"
      leave-active-class="animated fadeOut"
    >
      <q-list bordered separator>
        <q-item v-for="item in list" :key="item.id" clickable>
          <ItemBlock :item="item" class="full-width">
            <template v-slot:description>
              <div class="text-small-80 xs-hide sm-hide">
                <router-link :to="item.parentObject.url" class="text-primary">
                  для {{ item.parentObject.label }}
                </router-link>
              </div>
            </template>
            <template v-slot:default>
              <div class="text-small-70 lt-md ellipsis">
                <router-link :to="item.parentObject.url" class="text-primary">
                  для {{ item.parentObject.label }}
                </router-link>
              </div>
            </template>
            <template v-slot:header>
              <div class="row">
                <div v-if="item.actions.delete" class="cursor-pointer message-btn message-btn_delete  q-px-xs" @click="deleteItem(item)">
                  <q-icon name="close">
                    <q-tooltip anchor="top middle" self="bottom middle" :offset="[10, 10]">
                      <strong>Удалить</strong>
                    </q-tooltip>
                  </q-icon>
                </div>
                <AddBanUserBtn v-if="item.actions.ban" :user-uid="item.user.uid" :type="item.parentObject.type" :object-uid="item.parentObject.uid">
                  <div class="cursor-pointer message-btn message-btn_delete  q-px-xs">
                    <q-icon name="block">
                      <q-tooltip anchor="top middle" self="bottom middle" :offset="[10, 10]">
                        <span>Бан пользователя</span>
                      </q-tooltip>
                    </q-icon>
                  </div>
                </AddBanUserBtn>
              </div>
            </template>
          </ItemBlock>
        </q-item>
      </q-list>
    </transition-group>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import ItemBlock from 'src/Modules/Comments/components/MessageBlock/components/ItemBlock/index.vue'
import { deleteMessage } from 'src/Modules/Comments/api/commentApi'
import { useQuasar } from 'quasar'
import AddBanUserBtn from 'src/Modules/BanUsers/components/AddBanUserBtn/index.vue'

export default defineComponent({
  components: {
    ItemBlock,
    AddBanUserBtn
  },
  props: {
    list: {
      type: Array,
      required: true
    }
  },
  setup(props, { emit }) {
    const data = ref(null)
    const $q = useQuasar()
    const columns = ref(
      [
        {
          name: 'id',
          label: 'id',
          align: 'center',
        },
        {
          name: 'message',
          label: 'текс',
          align: 'left',
          sortable: true
        }
      ]
    )

    const deleteItem = (item) => {
      $q.dialog({
        title: 'Внимание',
        message: 'Удалить комментарий?',
        ok: {
          label: 'Удалить',
          color: 'negative'
        },
        cancel: true,
        persistent: true
      }).onOk(() => {
        item.delete = true
        const data = {
          uid: item.uid
        }
        deleteMessage(data)
          .catch(er => {
            item.delete = false
            $q.dialog({
              title: 'Ошибка удаления',
              message: er.response.data.errors,
              persistent: true
            })
          })
          .finally(() => {
            emit('reload')
          })
      })
    }
    return {
      data,
      columns,
      deleteItem
    }
  }
})
</script>

<style scoped>

</style>
