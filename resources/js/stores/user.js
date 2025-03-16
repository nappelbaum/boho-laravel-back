import { defineStore } from 'pinia'
import AuthService from '../api/AuthService'
import { getCookie } from '../utils/useCookie'

export const useUser = defineStore('user', {
  state: () => ({
    isAuth: getCookie('access_token') ? true : false,
    me: {}
  }),
  getters: {},
  actions: {
    async getMe(cb) {
      const res = await AuthService.getMe(cb)

      console.log(res)

      if (res) {
        this.isAuth = true
        this.me = res.data
      }
    },
    logout() {
      this.me = {}
      this.isAuth = false
    }
  }
})
