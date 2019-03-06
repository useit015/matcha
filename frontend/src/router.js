import Vue from 'vue'
import vueRouter from 'vue-router'
import Users from '@/components/Users'
import About from '@/components/About'
import Login from '@/components/Login'
import Register from '@/components/Register'

Vue.use(vueRouter)

export const router = new vueRouter({
	mode: 'history',
	base: process.env.BASE_URL,
	routes: [
		{
			path: '/',
			component: Users
		},
		{
			path: '/about',
			component: About
		},
		{
			path: '/register',
			component: Register
		},
		{
			path: '/login',
			component: Login
		}
	]
})