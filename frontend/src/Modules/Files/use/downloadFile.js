import { exportFile, Notify } from 'quasar'

export function useDownloadFile() {
  const downloadAndSaveFile = (func) => {
    func()
      .then(response => {
        let fileName = response.headers['content-disposition'].split('filename=')[1].split(';')[0]
        try {
          fileName = decodeURIComponent(response.headers['content-disposition'].split("filename*=utf-8''")[1].split(';')[0])
        } catch (e) {
        }
        const status = exportFile(fileName, response.data)
        if (status !== true) {
          Notify.create({
            message: 'Ошибка сохранения файла',
            color: 'negative'
          })
        }
      })
      .catch(() => {
        Notify.create({
          message: 'Ошибка получения файла',
          color: 'negative'
        })
      })
  }

  return {
    downloadAndSaveFile
  }
}
