// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import Bars from 'vuebars'
import Vue2Filters from 'vue2-filters'
import 'font-awesome/css/font-awesome.css'
// Require the main Sass manifest file
require('./assets/sass/main.scss')

Vue.use(Bars)
Vue.use(Vue2Filters)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
