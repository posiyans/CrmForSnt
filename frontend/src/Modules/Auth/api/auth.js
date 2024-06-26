import request from 'src/utils/request'

export function getInfo() {
  return request({
    url: '/api/v2/auth/info',
    method: 'get'
  })
}

export function userLoginByEmail(data) {
  return request({
    url: '/api/v2/auth/login',
    method: 'post',
    data
  })
}

export function userLogout() {
  return request({
    url: '/api/v2/auth/logout',
    method: 'get'
  })
}

export function getCsrfCookieToken() {
  return request({
    url: '/api/v2/csrf-cookie',
    method: 'get'
  })
}

export function userRegister(data) {
  return request({
    url: '/api/v2/auth/register',
    method: 'post',
    data
  })
}

export function passwordReset(data) {
  return request({
    url: '/api/v2/auth/password-send-reset-link',
    method: 'post',
    data
  })
}

export function changePasswordByToken(data) {
  return request({
    url: '/api/v2/auth/password-change',
    method: 'post',
    data
  })
}

export function getAuthPathVK(data) {
  return request({
    url: '/api/v2/vk/get-auth-path',
    method: 'get'
  })
}

export function sendVerifyEmail(data) {
  return request({
    url: '/api/v2/auth/send-verify-email',
    method: 'post',
    data
  })
}

export function getTwoFactorSettingsForUser(params) {
  return request({
    url: '/api/v2/auth/2f/get-for-user',
    method: 'get',
    params
  })
}

export function updateTwoFactorSettingsForUser(data) {
  return request({
    url: '/api/v2/auth/2f/update',
    method: 'post',
    data
  })
}
