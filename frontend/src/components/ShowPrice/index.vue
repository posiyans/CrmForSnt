<template>
  <div>
    {{ beforeText }}{{ formatedPrice }}{{ appendText }}
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, ref } from 'vue'

export default defineComponent({
  components: {},
  props: {
    price: {
      type: [String, Number],
      default: ''
    },
    hideIcon: {
      type: Boolean,
      default: false
    },
    appendText: {
      type: String,
      default: ''
    },
    beforeText: {
      type: String,
      default: ''
    }
  },
  setup(props, { emit }) {
    const data = ref(false)
    const formatedPrice = computed(() => {
      if (props.hideIcon) {
        return new Intl.NumberFormat('ru-RU').format(+props.price)
      } else {
        return new Intl.NumberFormat('ru-RU').format(+props.price) + ' руб.'
      }
    })
    return {
      data,
      formatedPrice
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
