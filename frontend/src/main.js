// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import vueRouter from 'vue-router'
import vueResource from 'vue-resource'
import Users from '@/components/Users'
import About from '@/components/About'

Vue.use(vueRouter)
Vue.use(vueResource)

const router = new vueRouter({
	routes: [{
			path: '/',
			component: Users
		},
		{
			path: '/about',
			component: About
		}
	]
})

new Vue({
	router,
	template: `
		<div id="app">
			<div class="bg-white mb-3 border-bottom shadow-sm">
				<div class="p-3 px-md-4 container d-flex flex-column flex-md-row align-items-center">
					<h5 class="my-0 mr-md-auto font-weight-normal">Matcha</h5>
					<nav class="my-2 my-md-0 mr-md-3">
						<router-link class="p-2 text-dark" to="/">Home</router-link>
						<router-link class="p-2 text-dark" to="/about">About</router-link>
					</nav>
					<a class="btn btn-outline-primary" href="#">Sign up</a>
				</div>
			</div>
			<router-view></router-view>
		</div>
	`
}).$mount('#app')
