import { boot } from 'quasar/wrappers'
import { createYmaps } from 'vue-yandex-maps'

export default boot(({ app }) => {
  if (process.env.YANDEX_MAP_API_KEY) {
    const ymaps = createYmaps({
      apikey: process.env.YANDEX_MAP_API_KEY
    })
    app.use(ymaps)
  }
})
