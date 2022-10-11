import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import 'boxicons/css/boxicons.min.css'
import Vuelidate from 'vuelidate'
import VueToast from 'vue-toast-notification';
import i18n from './plugins/i18n'
import 'vue-toast-notification/dist/theme-sugar.css';
import Multiselect from 'vue-multiselect'
import VueMoment from 'vue-moment'
import moment from 'moment-timezone'

Vue.use(VueMoment, {
  moment
})

Vue.component('multiselect', Multiselect)

Vue.config.productionTip = false

Vue.use(Vuelidate);

Vue.use(VueToast, {
  duration: 2000,
  dismissible: true,
  position: 'top-right'
});

new Vue({
  i18n,
  router,
  store,
  render: h => h(App)
}).$mount('#app')
