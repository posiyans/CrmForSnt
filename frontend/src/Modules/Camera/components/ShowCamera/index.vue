<template>
  <div class="q-pa-md">
    <div v-if="showName" class="text-weight-bolder q-pa-sm">
      {{ item.name }}
    </div>
    <div ref="imgContainerRef" :class="{ 'cursor-pointer': showAccess }" style="height: 140px;" @click="showFull">
      <q-skeleton
        v-if="loading"
        animation="pulse"
        width="250px"
        height="140px"
      />
    </div>
    <ShowImageFull v-if="fullImageVisible" :src-img="cameraUrl" :name="item.name" @close="fullImageVisible = false" />
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, onMounted, ref } from 'vue'
import { useAuthStore } from 'src/Modules/Auth/store/useAuthStore'
import ShowImageFull from 'src/Modules/Camera/components/ShowImageFull/index.vue'

export default defineComponent({
  components: {
    ShowImageFull
  },
  props: {
    item: Object,
    showName: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const fullImageVisible = ref(false)
    const loading = ref(true)
    const cameraOnline = ref(false)
    const imgContainerRef = ref(false)
    const showFull = () => {
      if (showAccess.value) {
        fullImageVisible.value = true
      }
    }
    const time = new Date().getTime()
    const authStore = useAuthStore()
    const showAccess = computed(() => {
      return authStore.checkPermission(['camera-show']) && cameraOnline.value
    })
    const cameraUrl = computed(() => {
      return process.env.BASE_API + '/api/v2/camera/get-image/' + props.item.id + '?s=' + time + '.jpg'
    })
    onMounted(() => {
      loading.value = true
      const image = new Image()
      image.src = cameraUrl.value
      image.onload = () => {
        loading.value = false
        image.height = 140
        imgContainerRef.value.appendChild(image)
        cameraOnline.value = true
      }
      image.onerror = () => {
        loading.value = false
        image.src = '/images/camera/camera_offline.jpg'
        cameraOnline.value = false
        imgContainerRef.value.appendChild(image)
      }
    })
    return {
      cameraUrl,
      imgContainerRef,
      showAccess,
      showFull,
      loading,
      fullImageVisible
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
