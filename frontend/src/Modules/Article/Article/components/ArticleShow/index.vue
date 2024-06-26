<template>
  <q-card>
    <q-card-section class="relative-position row items-center q-col-gutter-md q-py-none no-wrap">
      <div>
        <div class="text-weight-bold text-h6 overflow-hidden">
          {{ article.title }}
        </div>
        <div class="row items-center q-col-gutter-md text-grey-8 text-small-80">
          <div v-if="article.author">
            {{ article.author.name }}
          </div>
          <ShowTime :time="article.updated_at" />
        </div>
      </div>
      <q-space />
      <div v-if="article.status !== 2">
        <q-btn outline color="negative">
          <StatusShow :model-value="article.status" />
        </q-btn>
      </div>
      <div v-if="showEdit">
        <q-btn icon="settings" color="primary" flat :to="'/admin/article/edit/' + article.id" />
      </div>
    </q-card-section>
    <q-separator />
    <q-card-section v-if="showBody" class="q-px-xs-none q-pa-sm-sm">
      <RenderTextBlock :text="article.text" />
      <div v-if="article.files?.length > 0" class="q-gutter-sm">
        <FilesListShow :model-value="article.files" default-view="small">
          <template v-slot:before>
            <div class="text-weight-bold">Файлы:</div>
          </template>
        </FilesListShow>
      </div>
      <ArticleChatBlock :article="article" :scroll="scrollToMessage" />
    </q-card-section>
    <q-card-section v-if="!showBody">
      <div v-html="article.resume" class="q-px-sm"></div>
    </q-card-section>
  </q-card>
</template>

<script>
import { computed, defineComponent, ref } from 'vue'
import ShowTime from 'components/ShowTime/index.vue'
import { useAuthStore } from 'src/Modules/Auth/store/useAuthStore'
import FilesListShow from 'src/Modules/Files/components/FilesListShow/index.vue'
import StatusShow from 'src/Modules/Article/Article/components/StatusShow/index.vue'
import ArticleChatBlock from './components/ArticleChatBlock/index.vue'
import { useQuasar } from 'quasar'
import { useRoute } from 'vue-router'
import RenderTextBlock from 'src/Modules/RenderComponents/components/RenderTextBlock/index.vue'

export default defineComponent({
  components: {
    RenderTextBlock,
    ShowTime,
    FilesListShow,
    ArticleChatBlock,
    StatusShow
  },
  props: {
    article: {
      type: Object,
      required: true
    }
  },
  setup(props) {
    const commentsRef = ref(null)
    const authStore = useAuthStore()
    const route = useRoute()
    const $q = useQuasar()
    const showBody = computed(() => {
      if (authStore.permissions.includes('owner')) {
        return true
      }
      if (props.article.status === 2) {
        return true
      }
      if (props.article.text) {
        return true
      }
      return false
    })
    const showEdit = computed(() => {
      return $q.screen.width > 600 && authStore.checkPermission('article-edit')
    })

    const scrollToMessage = computed(() => {
      return route.hash === '#comments'
    })
    return {
      scrollToMessage,
      showBody,
      showEdit,
      authStore,
      commentsRef
    }
  }
})
</script>

<style scoped>

</style>
