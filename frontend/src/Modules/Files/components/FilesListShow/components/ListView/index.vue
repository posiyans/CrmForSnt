<template>
  <div class="q-gutter-sm">
    <div v-for="(file, index) in files" :key="file.uid">
      <div class="row items-center q-col-gutter-sm">
        <div>
          {{ ++index }}.
        </div>
        <div>
          <div v-if="file.model?.description">
            <div>
              {{ file.model?.description }}
            </div>
            <div class="text-small-65 o-60">
              {{ file.model?.name || file.name }}
            </div>
          </div>
          <div v-else>{{ file.model?.name || file.name }}</div>
        </div>
        <FileSize :size=" file.model?.size || file.size" class="text-grey-7 text-small-85" />
        <div v-if="file?.model?.url || file.url">
          <DownloadFileBtn :url-file="file?.model?.url || file.url" />
        </div>
        <div class="row items-center">
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
        <div v-if="edit">
          <div v-if="file.upload?.error" class="text-red">
            Ошибка {{ file.upload.errorsMessage }}
          </div>
        </div>
      </div>
      <div v-if="file.upload && !file.upload.success && file.upload.process > 0 && file.upload.process < 1" class="absolute-bottom full-width">
        <q-linear-progress :value="file.upload.process" class="" track-color="grey" size="3px" />
      </div>
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import FileItem from './../../FileItem.vue'
import FilePreview from 'src/Modules/Files/components/FilePreview/index.vue'
import { copyToClipboard, useQuasar } from 'quasar'
import FileSize from 'src/Modules/Files/components/FileSize/index.vue'
import DownloadFileBtn from 'src/Modules/Files/components/DownloadFileBtn/index.vue'
import DeleteIcon from 'src/Modules/Files/components/FilesListShow/DeleteIcon.vue'
import { successMessage } from 'src/utils/message'

export default defineComponent({
  components: {
    FileItem,
    FilePreview,
    FileSize,
    DownloadFileBtn,
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
