<template>
  <div @click="clearCache">
    <q-item clickable v-close-popup>
      <q-item-section>
        <q-item-label>Очистить кеш</q-item-label>
      </q-item-section>
    </q-item>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import { LocalStorage, Notify, SessionStorage } from 'quasar'

export default defineComponent({
  setup() {
    const clearCache = () => {
      LocalStorage.clear()
      SessionStorage.clear()
      Notify.create({
        message: 'Кеш очищен'
      })
    }
    return {
      clearCache
    }
  }
})
</script>

<style scoped>

</style>
