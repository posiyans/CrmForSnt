import { defineStore } from 'pinia'
import { createArticle, fetchArticle, updateArticle } from 'src/Modules/Article/Article/api/articleAdminApi'
import { useFile } from 'src/Modules/Files/hooks/useFile'
import { uid } from 'quasar'

export const useArticleStore = defineStore('articleStore', {
  state: () => ({
    id: null,
    key: 1,
    article: {
      uid: uid()
    },
    files: [],
    load: false,
    loading: false
  }),
  getters: {},
  actions: {
    init(id) {
      this.id = id
    },
    getData() {
      return new Promise((resolve, reject) => {
        this.loading = true
        fetchArticle(this.id)
          .then(response => {
            this.article = response.data.data
            this.files = []
            response.data.data.files.forEach(item => {
              const file = useFile()
              file.init(item)
              this.files.push(file)
            })
            // this.files = response.data.data.files
            resolve(this.article)
          })
          .catch(err => {
            reject(err)
          })
          .finally(() => {
            this.loading = false
          })
      })
    },
    saveArticle() {
      return new Promise((resolve, reject) => {
        if (this.id) {
          updateArticle(this.id, this.article)
            .then(res => {
              resolve()
            })
            .catch(err => {
              reject(err)
            })
        } else {
          createArticle(this.article)
            .then(res => {
              resolve(res.data)
            })
            .catch(err => {
              reject(err)
            })
        }
      })
    }
  }
})
