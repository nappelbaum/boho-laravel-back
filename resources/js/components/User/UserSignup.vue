<script setup>
import { ref } from 'vue'
import AuthService from '../../api/AuthService'
import { setCookie, getCookie } from '../../utils/useCookie'
import { useRouter } from 'vue-router'
import { useUser } from '../../stores/user'

const user = useUser()

const router = useRouter()

const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')

const nameWarning = ref('')
const emailWarning = ref('')
const confirmationWarning = ref('')

const onSubmit = async () => {
  const res = await AuthService.signup(
    name.value,
    email.value,
    password.value,
    password_confirmation.value
  )

  if (res.data.access_token) {
    user.getMe(() => {})
    setCookie('access_token', res.data?.access_token)
    router.push({ name: 'user.personal' })
  } else if (res.data.message === 'User with this email exists')
    emailWarning.value = 'Пользователь с таким email существует'
  else {
    if (res.data.message === 'The name field is required.')
      nameWarning.value = 'Введите имя пользователя'
    if (res.data.message === 'The email field is required.')
      emailWarning.value = 'Введите email пользователя'
    if (res.data.message === 'The email field must be a valid email address.')
      emailWarning.value = 'Не валидный email'
    if (res.data.message === 'The password field confirmation does not match.')
      confirmationWarning.value = 'Повторный пароль не совпал'
  }
}
</script>

<template>
  <div class="container">
    <div v-if="!getCookie('access_token')" class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Register</div>

          <div class="card-body">
            <form @submit.prevent="onSubmit">
              <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                <div class="col-md-6">
                  <input
                    v-model="name"
                    id="name"
                    type="text"
                    class="form-control"
                    name="name"
                    required
                    autocomplete="name"
                    autofocus
                    @input="nameWarning = ''"
                  />

                  <span class="text-danger" role="alert">
                    <strong>{{ nameWarning }}</strong>
                  </span>
                </div>
              </div>

              <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

                <div class="col-md-6">
                  <input
                    v-model="email"
                    id="email"
                    type="email"
                    class="form-control"
                    name="email"
                    required
                    autocomplete="email"
                    autofocus
                    @input="emailWarning = ''"
                  />

                  <span class="text-danger" role="alert">
                    <strong>{{ emailWarning }}</strong>
                  </span>
                </div>
              </div>

              <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

                <div class="col-md-6">
                  <input
                    v-model="password"
                    id="password"
                    type="password"
                    class="form-control"
                    name="password"
                    required
                    autocomplete="current-password"
                    @input="confirmationWarning = ''"
                  />
                </div>
              </div>

              <div class="row mb-3">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-end"
                  >Confirm Password</label
                >

                <div class="col-md-6">
                  <input
                    v-model="password_confirmation"
                    id="password-confirm"
                    type="password"
                    class="form-control"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    @input="confirmationWarning = ''"
                  />

                  <span class="text-danger" role="alert">
                    <strong>{{ confirmationWarning }}</strong>
                  </span>
                </div>
              </div>

              <div class="row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">Register</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
