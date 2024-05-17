<template>
  <div class="stead-grid-block row justify-center q-py-sm text-center">
    <div v-if="loading">
      <q-spinner-dots
        color="grey"
        size="1em"
      />
    </div>
    <div v-else>
      <ShowSteadNumber :stead="stead" :color="color" />
      <slot name="after"></slot>
      <div class="text-small-80">
        {{ after }}
      </div>
      <q-tooltip v-if="tooltip">
        {{ tooltip }}
      </q-tooltip>
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, onMounted, ref } from 'vue'
import ShowSteadNumber from 'src/Modules/Stead/components/ShowSteadNumber/index.vue'

export default defineComponent({
  components: {
    ShowSteadNumber
  },
  props: {
    stead: {
      type: Object,
      required: true
    },
    color: {
      type: String,
      default: 'black'
    },
    tooltip: {
      type: String,
      default: ''
    },
    after: {
      type: String,
      default: ''
    },
    loading: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const data = ref(null)
    const styleName = computed(() => {
      const style = {}
      if (props.color) {
        style.color = props.color
      }
      return style
    })
    onMounted(() => {

    })
    return {
      data,
      styleName
    }
  }
})
</script>

<style scoped>
.stead-grid-block {
  width: 150px;
  border: 1px solid black;
  margin-left: -1px;
  margin-top: -1px;
}
</style>
