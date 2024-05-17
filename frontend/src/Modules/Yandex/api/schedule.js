import request from 'src/utils/request'

export function fetchYandexSchedule(query) {
  return request({
    url: '/api/v2/yandex/schedule/get',
    method: 'get',
    params: query
  })
}

export function fetchYandexScheduleSettings() {
  return request({
    url: '/api/v2/yandex/schedule/settings/get',
    method: 'get'
  })
}

export function updateYandexScheduleSettings(data) {
  return request({
    url: '/api/v2/yandex/schedule/settings/update',
    method: 'post',
    data
  })
}
