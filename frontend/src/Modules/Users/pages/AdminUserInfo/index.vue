<template>
  <div class="q-pa-md">
    <div class="o-60 row items-center q-col-gutter-sm">
      <div class="">
        <router-link to="/admin/user/list">
          Все пользователи
        </router-link>
      </div>
      <div>
        ->
      </div>
      <div>
        Профиль пользвателя
      </div>
    </div>
    <ActiveUserCart />
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, onMounted, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useActiveUserStore } from 'src/Modules/Users/stores/useActiveUserStore'
import ActiveUserCart from 'src/Modules/Users/components/ActiveUserCart/index.vue'

export default defineComponent({
  components: {
    ActiveUserCart
  },
  props: {},
  setup() {
    const data = ref(null)
    const route = useRoute()
    const dialogVisible = ref(false)
    const activeUserStore = useActiveUserStore()
    const showDialog = () => {
      activeUserStore.init(route.params.uid)
      activeUserStore.getUserInfo()
      dialogVisible.value = true
    }
    onMounted(() => {
      showDialog()
    })
    watch(
      () => route.params.uid,
      () => showDialog()
    )
    return {
      data,
      activeUserStore
    }
  }
})
</script>

<style scoped>

</style>
