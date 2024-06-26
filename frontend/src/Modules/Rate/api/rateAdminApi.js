import request from 'src/utils/request'

export function createRateType(data) {
  return request({
    url: '/api/v2/rate/type/create',
    method: 'post',
    data
  })
}

export function updateRateType(id, data) {
  return request({
    url: '/api/v2/rate/type/update/' + id,
    method: 'post',
    data
  })
}

export function deleteRateType(id) {
  return request({
    url: '/api/v2/rate/type/delete/' + id,
    method: 'delete'
  })
}

export function updateRateGroup(id, data) {
  return request({
    url: '/api/v2/rate/group/update/' + id,
    method: 'post',
    data
  })
}

export function updateRate(id, data) {
  return request({
    url: '/api/v2/rate/update/' + id,
    method: 'post',
    data
  })
}

export function createRateGroup(data) {
  return request({
    url: '/api/v2/rate/group/create',
    method: 'post',
    data
  })
}

export function getRateGroupList(params) {
  return request({
    url: '/api/v2/rate/group/get-list',
    method: 'get',
    params
  })
}

export function getRateListForGroup(id, params) {
  return request({
    url: '/api/v2/rate/get/' + id,
    method: 'get',
    params
  })
}

export function getRateDependsList() {
  return new Promise(resolve => {
    const resData = [
      {
        value: 1,
        label: 'расчет от участка'
      },
      {
        value: 2,
        label: 'расчет по показаниям'
      },
      {
        value: 3,
        label: 'фиксированная сумма'
      }
    ]
    resolve({
      data: {
        data: resData
      }
    })
  })
}
