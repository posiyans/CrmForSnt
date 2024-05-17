import request from 'src/utils/request'

export function getBalanceList(params) {
  request.defaults.timeout = 50000
  return request({
    url: '/api/v2/billing/balance/get-list',
    method: 'get',
    params
  })
}

export function getFullBalanceForStead(params) {
  request.defaults.timeout = 50000
  return request({
    url: '/api/v2/billing/balance/get-full-list',
    method: 'get',
    params
  })
}

export function getFullBalanceForSteadXlsx(params) {
  request.defaults.timeout = 50000
  return request({
    url: '/api/v2/billing/balance/get-full-list',
    method: 'get',
    responseType: 'blob',
    params
  })
}

export function getBalanceListXlsx(params) {
  request.defaults.timeout = 50000
  return request({
    url: '/api/v2/billing/balance/get-list',
    method: 'get',
    responseType: 'blob',
    params
  })
}
