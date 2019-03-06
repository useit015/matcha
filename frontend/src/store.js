import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export const store = new Vuex.Store({
	strict: true,
	state: {
		status: false,
		user: {}
	},
	getters: {
		
	},
	mutations: {
		logout: state => {
			state.status = false
			state.user = {}
		},
		login: (state, user) => {
			state.status = true
			state.user = user
		}
	},
	actions: {
		login:(context, user) => {
			localStorage.setItem("token", user.token)
			localStorage.setItem("tokenExpiration", user.tokenExpiration)
			context.commit('login', user)
		},
		logout: (context) => {
			localStorage.removeItem("token")
			context.commit('logout')
		}
	}
});