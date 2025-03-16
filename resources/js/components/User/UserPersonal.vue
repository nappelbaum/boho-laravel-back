<script setup>
import { computed, ref } from 'vue'
import { useUser } from '../../stores/user'
import { getCookie } from '../../utils/useCookie'

const user = useUser()
const isAuth = computed(() => user.isAuth)

import { useJwt } from '@vueuse/integrations/useJwt'
// необходимо установить "@vueuse/core" , "@vueuse/integrations" и "npm install jwt-decode@^3"

const encodedJwt = ref(getCookie('access_token'))
const { header, payload } = useJwt(encodedJwt)

console.log(header.value)
console.log(payload.value)
</script>

<template>
  <section v-if="isAuth">
  </section>
</template>
