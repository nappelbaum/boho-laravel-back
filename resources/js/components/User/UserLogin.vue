<script setup>
import { computed, ref } from 'vue'
import AuthService from '../../api/AuthService'
import { setCookie } from '../../utils/useCookie'
import { useUser } from '../../stores/user'

const user = useUser()

const email = ref('')
const password = ref('')
const remember = ref(false)

const warning = ref('')

const isAuth = computed(() => user.isAuth)

const onSubmit = async () => {
  const res = await AuthService.login(email.value, password.value)

  if (res.data?.access_token) {
    user.getMe(() => {})
    setCookie('access_token', res.data?.access_token)
    window.location.replace('/admin')
  } else warning.value = 'Неверный email или пароль'
}
</script>

<template>
  <div v-if="!isAuth" class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Login</div>

        <div class="card-body">
          <form @submit.prevent="onSubmit">
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
                  @input="warning = ''"
                />
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
                  @input="warning = ''"
                />

                <span class="text-danger" role="alert">
                  <strong>{{ warning }}</strong>
                </span>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 offset-md-4">
                <div class="form-check">
                  <input
                    v-model="remember"
                    class="form-check-input"
                    type="checkbox"
                    name="remember"
                    id="remember"
                  />

                  <label class="form-check-label" for="remember"> Remember Me </label>
                </div>
              </div>
            </div>

            <div class="row mb-0">
              <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">Login</button>

                <!-- <a class="btn btn-link" href="/password/reset"> Forgot Your Password? </a> -->
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
