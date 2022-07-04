import Welcome from './components/WelcomeComponent.vue'
export default {
  mode: 'history',
  base: '/LaravelVue/',
  fallback: true,
  routes: [
    {
      path: '/',
      component: Welcome,
      name: Welcome
    }
  ] 
}