<template>
  <div>
    <span v-if="addArrow" class="o-60">
      >
    </span>
    <span class="cursor-pointer breadcrumb" @click="toRoute">
      {{ item?.label }}
    </span>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import { useRouter } from 'vue-router'

export default defineComponent({
  props: {
    item: {
      type: Object,
      default: () => {
        return { label: '' }
      }
    },
    addArrow: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const data = ref(false)
    const router = useRouter()
    const toRoute = () => {
      if (props.item.id) {
        router.push('/article/list/' + props.item.id)
      } else {
        router.push('/')
      }
    }
    return {
      data,
      toRoute
    }
  }
})
</script>

<style scoped lang='scss'>
.breadcrumb {
  &:hover {
    opacity: 0.65;
  }

  //height: 50px;
}
</style>

