<template>
  <div>
    <div class="page-title">
      Расписание электричек
    </div>
    <div class="q-px-none q-px-sm-md">
      <YandexSchedule />
    </div>
  </div>
</template>

<script>
import YandexSchedule from 'src/Modules/Yandex/components/YandexSchedule/index.vue'

export default {
  components: {
    YandexSchedule
  }

}
</script>

<style scoped>
</style>
