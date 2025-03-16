import axios from 'axios'
import createApi from './myApi'

export default class PostService {
  static async signup(name, email, password, password_confirmation) {
    try {
      const res = await axios.post('/api/users', {
        name,
        email,
        password,
        password_confirmation
      })

      return res
    } catch (err) {
      return err.response
    }
  }

  static async login(email, password) {
    try {
      const res = await axios.post('/api/auth/login', { email, password })

      return res
    } catch (err) {
      return null
    }
  }

  static async getFruits(cb) {
    const res = await createApi(cb).get('/api/auth/fruits')
    return res
  }

  static async getMe(cb) {
    const res = await createApi(cb).post('/api/auth/me')
    return res
  }

  static async logout(cb) {
    const res = await createApi(cb).post('/api/auth/logout')
    return res
  }
}
