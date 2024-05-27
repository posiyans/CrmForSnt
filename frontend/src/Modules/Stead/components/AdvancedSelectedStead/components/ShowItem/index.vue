<template>
  <div>
    <q-chip outline square color="primary" text-color="white">
      {{ item.number }}
      <q-tooltip>
        {{ item.find }}
      </q-tooltip>
    </q-chip>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'

export default defineComponent({
  components: {},
  props: {
    item: {
      type: Object,
      default: () => {
      }
    },
    find: {
      type: String,
      default: ''
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
