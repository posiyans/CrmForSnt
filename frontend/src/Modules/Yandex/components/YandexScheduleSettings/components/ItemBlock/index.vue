<template>
  <div class="" :class="{'o-20' : passed, row: desktop }">
    <div v-if="desktop" class="q-pa-sm">
      <img
        :src="item.thread.carrier.logo"
        width="65"
      />
    </div>
    <div class="col-grow">
      <div class="row items-center">
        <div v-if="mobile" class="q-mr-xs">
          <img
            :src="item.thread.carrier.logo"
            width="35"
          />
        </div>
        <div>
          <div class="q-mr-lg text-primary">
            <a
              :href="'https://rasp.yandex.ru/thread/' + item.thread.uid"
              :title="'Расписание электрички ' + item.thread.number + ' ' + item.thread.title"
              class="q-col-gutter-sm"
            >
              <span class="text-weight-bold">{{ item.thread.number }}</span>
              <span>{{ item.thread.title }}</span>
            </a>

          </div>
          <div class="text-small-80" :style="'color: ' + item.thread.transport_subtype.color">
            {{ item.thread.transport_subtype.title }}
          </div>
        </div>
      </div>

      <div class="full-width q-pa-sm">
        <table class="TimeAndStations">
          <tbody>

          <tr>
            <td>
              <div class="row items-center">
                <div v-if="type === 2" class="text-weight-bolder text-big-40">{{ item.departure.substring(0, 5) }}</div>
                <ShowTime v-else :time="item.departure" format="HH:mm" class="text-weight-bolder  text-big-40" />
                <div class="TimeAndStations__line"></div>
                <ShowDuration :time="item.duration" format="HH:mm" class="text-small-90 text-grey" />
                <div class="TimeAndStations__line"></div>
              </div>
            </td>
            <td>
              <div v-if="type === 2" class="text-weight-bolder">{{ item.arrival.substring(0, 5) }}</div>
              <ShowTime v-else :time="item.arrival" format="HH:mm" class="text-weight-bolder" />
            </td>
          </tr>
          <tr>
            <td>
              <div class="text-small-80 o-80">
                {{ item.from.popular_title || item.from.title }}
              </div>
            </td>
            <td>
              <div class="text-small-80 o-80">
                {{ item.to.popular_title || item.to.title }}
              </div>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
      <div v-if="item.days" class="q-px-sm o-60">
        {{ item.days }}
      </div>
      <div v-if="item.except_days" class="text-negative q-px-sm">
        кроме {{ item.except_days }}
      </div>
      <div class="o-60 q-pa-sm">
        Остановки: {{ item.stops }}
      </div>
    </div>
    <q-separator v-if="mobile && item.tickets_info" />
    <div v-if="item.tickets_info" class="text-primary text-weight-bold q-pa-sm text-big-20">
      <ShowPrice :price="item.tickets_info.places[0].price.whole" />
    </div>

  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, ref } from 'vue'
import ShowTime from 'components/ShowTime/index.vue'
import ShowDuration from 'src/components/ShowDuration/index.vue'
import ShowPrice from 'src/components/ShowPrice/index.vue'
import { useQuasar } from 'quasar'

export default defineComponent({
  components: {
    ShowTime,
    ShowDuration,
    ShowPrice
  },
  props: {
    item: {
      type: Object,
      required: true
    },
    type: {
      type: Number,
      defaullt: 0
    }
  },
  setup(props, { emit }) {
    const data = ref(false)
    const passed = computed(() => {
      return false
      // todo нужно учесть временную зону
      // return new Date(props.item.departure) < new Date() && props.type == 0
    })
    const $q = useQuasar()
    const mobile = computed(() => {
      return $q.screen.width < 700
    })
    const desktop = computed(() => {
      return !mobile.value
    })
    return {
      data,
      passed,
      mobile,
      desktop
    }
  }
})
</script>

<style scoped lang='scss'>
.TimeAndStations {
  width: 100%;
  max-width: 600px;
  border-collapse: collapse;
  font-size: 13px;
  line-height: 16px;
}

.TimeAndStations__line {
  height: 1px;
  background-color: #e6e6e6;
  flex: 1 0 5px;
  box-sizing: border-box;
  margin: 0 3px;
}
</style>
