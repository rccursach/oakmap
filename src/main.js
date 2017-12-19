// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import Bars from 'vuebars'
import Vue2Filters from 'vue2-filters'

Vue.use(Bars)
Vue.use(Vue2Filters)

window.$ = window.jQuery = require('jquery')
require('semantic-ui-css/semantic.css')
require('semantic-ui-css/semantic.js')

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
