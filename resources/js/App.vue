<!-- src/App.vue -->

<template>
  <div id="app">
    <NavBar />
    <router-view />
    <FooterSection />
  </div>
</template>

<script>
import NavBar from './components/partials/NavBar.vue';
import FooterSection from './components/partials/FooterSection.vue';

export default {
  name: 'app',
  components: {
    NavBar,
    FooterSection,
  },
};
</script>

<style lang="scss">
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
</style>
