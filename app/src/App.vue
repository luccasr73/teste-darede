<template>
  <v-app>
   <router-view/>
  </v-app>
</template>

<script>
export default {
  name: 'App',
  watch: {
    $route: {
      handler: (to, from) => {
        document.title = to.meta.title || 'Teste Darede'
      },
      immediate: true
    }
  }
}
</script>
