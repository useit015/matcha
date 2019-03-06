import Vue from 'vue'
import Vuetify from 'vuetify'
import vueResource from 'vue-resource'
import { router } from './router'
import { store } from './store'
import 'vuetify/dist/vuetify.min.css'
import App from './App'

Vue.use(Vuetify)
Vue.use(vueResource)

new Vue({
	store,
	router,
	render: h => h(App)
}).$mount('#app')
