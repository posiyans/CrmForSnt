<template>
  <div>
    <UserAddNewsBtn class="q-pa-sm" />
    <AllArticleList />
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import AllArticleList from 'src/Modules/Article/Article/components/AllArticleList/index.vue'
import UserAddNewsBtn from 'src/Modules/Article/Article/components/UserAddNewsBtn/index.vue'

export default defineComponent({
  components: {
    AllArticleList,
    UserAddNewsBtn
  },
  setup() {
    return {}
  }
})
</script>
