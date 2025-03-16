import axios from 'axios'

import { getCookie, setCookie, eraseCookie } from '../utils/useCookie'

export default function createApi(cb) {
  const myApi = axios.create()

  //start request
  myApi.interceptors.request.use(
    (config) => {
      if (getCookie('access_token')) {
        config.headers.authorization = `Bearer ${getCookie('access_token')}`
      }

      return config
    },
    () => cb()
  )
  //end request

  //start response
  myApi.interceptors.response.use(
    (config) => {
      if (getCookie('access_token')) {
        config.headers.authorization = `Bearer ${getCookie('access_token')}`
      }

      return config
    },
    async (error) => {
      if (error.response.data.message === 'Token has expired') {
        return await axios
          .post(
            '/api/auth/refresh',
            {},
            {
              headers: {
                authorization: `Bearer ${getCookie('access_token')}`
              }
            }
          )
          .then((res) => {
            setCookie('access_token', res.data.access_token)
            error.config.headers.authorization = `Bearer ${res.data.access_token}`
            return myApi.request(error.config)
          })
          .catch((error) => {
            if (error.response.status === 500) {
              eraseCookie('access_token')
              cb()
            }
          })
      }
      if (error.response.status === 401) {
        cb()
      }
    }
  )
  //end response

  return myApi
}
