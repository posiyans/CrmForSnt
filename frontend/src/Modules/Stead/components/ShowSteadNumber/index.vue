<template>
  <router-link :to="`/admin/stead/info/${stead.id}`">
    <q-chip outline square :color="color" text-color="white">
      {{ stead.number }}
    </q-chip>
  </router-link>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'

export default defineComponent({
  components: {},
  props: {
    stead: {
      type: Object,
      required: true
    },
    color: {
      type: String,
      default: 'primary'
    }
  },
  setup(props, { emit }) {
    const data = ref(false)
    return {
      data
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
