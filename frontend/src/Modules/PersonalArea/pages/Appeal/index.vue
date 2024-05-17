<template>
  <q-card class="bg-white">
    <q-card-section>
      <AppealList :user-uid="authStore.user.uid" :key="key">
        <AddAppealBtn v-if="authStore.user.uid" :user-uid="authStore.user.uid" @success="reloadData">
          <q-btn icon="add" outline color="primary" :label="btnLabel" no-wrap />
        </AddAppealBtn>
      </AppealList>
    </q-card-section>
  </q-card>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, ref } from 'vue'
import { useAuthStore } from 'src/Modules/Auth/store/useAuthStore'
import AppealList from 'src/Modules/Appeal/components/AppealList/index.vue'
import AddAppealBtn from 'src/Modules/Appeal/components/AddAppealBtn/index.vue'
import { useQuasar } from 'quasar'

export default defineComponent({
  components: {
    AppealList,
    AddAppealBtn
  },
  props: {},
  setup(props, { emit }) {
    const key = ref(1)
    const authStore = useAuthStore()
    const $q = useQuasar()
    const btnLabel = computed(() => {
      return $q.screen.width > 500 ? 'Создать' : undefined
    })
    const reloadData = (val) => {
      key.value++
    }
    return {
      key,
      authStore,
      reloadData,
      btnLabel

    }
  }
})
</script>

<style scoped lang='scss'>

</style>
