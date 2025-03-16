<script setup>
import { computed, onBeforeMount } from 'vue'
import { useUser } from '../stores/user'
import AuthService from '../api/AuthService'
import { eraseCookie } from '../utils/useCookie'
import { useRouter } from 'vue-router'

const router = useRouter()

const user = useUser()
const isAuth = computed(() => user.isAuth)

const logout = async () => {
  if (isAuth.value) {
    await AuthService.logout(() => {})

    user.logout()
    eraseCookie('access_token')

    window.location.replace('/users/login')
  }
}

onBeforeMount(() => {
  if (!isAuth.value) router.push({ name: 'user.login' })
})

</script>

<template>
  <nav class="d-flex column-gap-2 mb-4">
    <router-link v-if="!isAuth" to="/users/login">login</router-link>
    <a v-if="isAuth" href="" @click.prevent="logout">logout</a>
  </nav>
  <router-view></router-view>
</template>
