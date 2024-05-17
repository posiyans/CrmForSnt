<template>
  <div class="row">
    <div
      v-for="stead in SteadsList"
      :key="stead.id"
    >
      <div class="stead-grid-block row justify-center q-py-sm text-center">
        <div v-if="loading">
          <q-spinner-dots
            color="grey"
            size="1em"
          />
        </div>
        <div v-else>
          <ShowSteadNumber :stead="stead" :color="colorStead[stead.id]" />
          <slot name="after" v-bind:steadId="stead.id" v-bind:steadNumber="stead.number"></slot>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, onMounted, ref } from 'vue'
import { getSteadsList } from 'src/Modules/Stead/api/stead'
import ShowSteadNumber from 'src/Modules/Stead/components/ShowSteadNumber/index.vue'


export default defineComponent({
  components: {
    ShowSteadNumber
  },
  props: {
    colorStead: {
      type: Object,
      default: () => {
        return {}
      }
    },
    loading: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const SteadsList = ref([])
    const getData = () => {
      getSteadsList()
        .then(response => {
          SteadsList.value = response.data.data
        })
    }
    onMounted(() => {
      getData()
    })

    return {
      SteadsList
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
