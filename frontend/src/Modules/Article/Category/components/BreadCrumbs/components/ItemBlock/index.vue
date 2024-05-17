<template>
  <div class="cursor-pointer" @click="toRoute">
    <span class="breadcrumb">
      {{ item?.label }}
    </span>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent } from 'vue'
import { useRouter } from 'vue-router'

export default defineComponent({
  props: {
    item: {
      type: Object,
      default: () => {
        return { label: '' }
      }
    },
  },
  setup(props, { emit }) {
    const router = useRouter()
    const toRoute = () => {
      if (props.item.id) {
        router.push('/article/list/' + props.item.id)
      } else {
        router.push('/')
      }
    }
    return {
      toRoute
    }
  }
})
</script>

<style scoped lang='scss'>
.breadcrumb {
  &:hover {
    opacity: 0.6;
  }
}
</style>

