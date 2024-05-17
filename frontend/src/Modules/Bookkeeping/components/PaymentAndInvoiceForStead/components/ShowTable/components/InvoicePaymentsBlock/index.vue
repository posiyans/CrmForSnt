<template>
  <div>
    <div v-if="paymentsCount > 0" :class="paymentsSumError">
      {{ paymentsCount }}
      <DecOfNum :number="paymentsCount" :titles="['счет','счета','счетов']" />
      <ShowPrice before-text="на " :price="paymentsSum" />
    </div>

  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, ref } from 'vue'
import DecOfNum from 'components/DecOfNum/index.vue'
import ShowPrice from 'components/ShowPrice/index.vue'

export default defineComponent({
  components: {
    DecOfNum,
    ShowPrice
  },
  props: {
    invoice: {
      type: Object,
      required: true
    }
  },
  setup(props, { emit }) {
    const data = ref(false)
    const paymentsCount = computed(() => {
      return props.invoice.payments.length || 0
    })
    const paymentsSumError = computed(() => {
      if (Math.abs(+props.invoice.price - paymentsSum.value) > 1) {
        return 'text-negative'
      }
      return ''
    })
    const paymentsSum = computed(() => {
      if (paymentsCount.value > 0) {
        return props.invoice.payments.reduce((accum, item) => {
          return accum + +item.price
        }, 0)
      }
      return 0
    })
    return {
      data,
      paymentsCount,
      paymentsSum,
      paymentsSumError
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
