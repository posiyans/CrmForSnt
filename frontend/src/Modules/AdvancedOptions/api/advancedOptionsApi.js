import request from 'src/utils/request'

export function addAdvancedOptions(data) {
  return request({
    url: '/api/v2/advanced-options',
    method: 'post',
    data
  })
}

export function getAdvancedOptionsList(params) {
  return request({
    url: '/api/v2/advanced-options',
    method: 'get',
    params
  })
}

export function addAdvancedOptionsValue(id, data) {
  return request({
    url: '/api/v2/advanced-options/value/' + id,
    method: 'post',
    data
  })
}

export function editAdvancedOptionsValue(id, data) {
  return request({
    url: '/api/v2/advanced-options/value/' + id,
    method: 'put',
    data
  })
}

export function getAdvancedOptionsType() {
  return new Promise((resolve, reject) => {
    resolve({
      data: {
        data: [
          {
            value: 'string',
            label: 'Строка'
          },
          {
            value: 'boolean',
            label: 'Да/Нет'
          },
          {
            value: 'select',
            label: 'Выбор'
          },
          {
            value: 'multi_select',
            label: 'Множественный выбор'
          }
        ]
      }
    })
  })
}
