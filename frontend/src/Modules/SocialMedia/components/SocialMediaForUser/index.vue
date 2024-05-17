<template>
  <div>
    <div v-if="loading">
      <q-spinner-dots
        color="primary"
        size="2em"
      />
    </div>
    <div v-else class="row q-col-gutter-md items-center">
      <div v-if="listObject.vkontakte">
        <a :href="'https://vk.com/id' + listObject.vkontakte" target="_blank">
          <img src="~assets/SocialMedia/Vk/vk-logo.svg" width="23" alt="vk">
        </a>
      </div>
      <div v-else class="o-20">
        <img src="~assets/SocialMedia/Vk/vk-logo.svg" width="23" alt="vk">
      </div>
    </div>
  </div>
</template>

<script>
import { computed, defineComponent, onMounted, ref } from 'vue'
import { getSocialMedia } from 'src/Modules/SocialMedia/api/apiSocialMedia'

export default defineComponent({
  components: {},
  props: {
    userUid: {
      type: String,
      default: null
    }
  },
  setup(props, { emit }) {
    const list = ref([])
    const loading = ref(false)
    const listObject = computed(() => {
      const tmp = {}
      list.value.forEach(item => {
        tmp[item.provider_name] = item.provider_id
      })
      return tmp
    })
    const getData = () => {
      loading.value = true
      const data = {
        user_uid: props.userUid
      }
      getSocialMedia(data)
        .then(res => {
          list.value = res.data.data
        })
        .finally(() => {
          loading.value = false
        })
    }
    onMounted(() => {
      getData()
    })
    return {
      loading,
      listObject
    }
  }
})
</script>

<style scoped>

</style>
