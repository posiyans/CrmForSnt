<template>
  <div class="row items-center q-col-gutter-sm">
    <div v-for="file in files" :key="file.uid">
      <q-card>
        <q-card-section v-if="file.model?.description" class="q-py-none">
          <div>{{ file.model?.description }}</div>
        </q-card-section>
        <q-card-section class="row q-pa-xs items-center">
          <FileItem :file="file" :get-url="getUrl" :show-preview="true" class="q-ml-xs" />
          <div v-if="edit || getUrl" class="absolute-top-right bg-white q-pa-xs">
            <div class="text-secondary row items-center">
              <q-btn v-if="getUrl" flat icon="content_copy" size="sm" color="secondary" class="q-pa-xs" @click="emitUrl(file.url || file?.model?.url)">
                <q-tooltip>
                  Скопировать ссылку
                </q-tooltip>
              </q-btn>
              <q-btn v-if="edit" flat icon="delete" size="sm" color="negative" class="q-pa-xs" @click="deleteFile(file)">
                <q-tooltip>
                  Удалить файл
                </q-tooltip>
              </q-btn>
            </div>
            <div v-if="file.upload?.error" class="text-red">
              Ошибка {{ file.upload.errorsMessage }}
            </div>
          </div>
        </q-card-section>
        <div v-if="file.upload && !file.upload.success && file.upload.process > 0 && file.upload.process < 1" class="absolute-bottom full-width">
          <q-linear-progress :value="file.upload.process" class="" track-color="grey" size="3px" />
        </div>
      </q-card>
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import FileItem from './../../FileItem.vue'
import FilePreview from 'src/Modules/Files/components/FilePreview/index.vue'
import { copyToClipboard, useQuasar } from 'quasar'
import DeleteIcon from 'src/Modules/Files/components/FilesListShow/DeleteIcon.vue'
import { successMessage } from 'src/utils/message'

export default defineComponent({
  components: {
    FileItem,
    FilePreview,
    DeleteIcon
  },
  props: {
    files: {
      type: Array,
      required: true
    },
    getUrl: {
      type: Boolean,
      default: false
    },
    edit: {
      type: Boolean,
      default: false
    },
  },
  setup(props, { emit }) {
    const data = ref(false)
    const $q = useQuasar()
    const deleteFile = (file) => {
      if (props.edit) {
        $q.dialog({
          title: 'Внимание?',
          message: 'Удалить файл?',
          cancel: true,
          persistent: true
        }).onOk(() => {
          file.deleteFile()
            .then(() => {
              const data = props.files.map(item => {
                if (item === file) {
                  item.delete = true
                }
                return item
              })
            })
            .catch(() => {
              $q.notify(
                {
                  message: 'Ошибка удаления файла',
                  type: 'negative'
                }
              )
            })
        })
      }
    }
    const emitUrl = (url) => {
      copyToClipboard(url)
        .then(() => {
          successMessage('Ссылка скопирована')
        })
    }
    return {
      data,
      deleteFile,
      emitUrl
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
