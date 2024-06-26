import request from 'src/utils/request'

export function getPaymentList(params) {
  return request({
    url: '/api/v2/billing/payment/get-list',
    method: 'get',
    params
  })
}

export function getPaymentListXlsx(params) {
  request.defaults.timeout = 60000
  return request({
    url: '/api/v2/billing/payment/get-list',
    method: 'get',
    responseType: 'blob',
    params
  })
}

export function getPayment(id) {
  return request({
    url: '/api/v2/billing/payment/' + id,
    method: 'get'
  })
}

export function updatePayment(id, data) {
  return request({
    url: '/api/v2/billing/payment/' + id,
    method: 'post',
    data
  })
}

export function deletePayment(id) {
  return request({
    url: '/api/v2/billing/payment/' + id,
    method: 'delete'
  })
}

export function deletePaymentFromInvoice(paymentId) {
  return request({
    url: '/api/v2/billing/payment/from-invoice/' + paymentId,
    method: 'delete'
  })
}

export function addPayment(data) {
  return request({
    url: '/api/v2/billing/payment/',
    method: 'post',
    data
  })
}
