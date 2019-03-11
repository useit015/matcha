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
		user: state => state.user,
		status: state => state.status
	},
	mutations: {
		updateTags: (state, tags) => state.user.tags = tags.map(cur => cur.text.toLowerCase()).join(','),
		updateUser: (state, user) => state.user = user,
		logout: state => {
			state.status = false
			state.user = {}
		},
		login: (state, user) => {
			state.status = true
			state.user = user
		},
	},
	actions: {
		updateUser: (context, user) => {
			context.commit('updateUser', user)
			// context.commit('updateTags', user)
		},
		login:(context, user) => {
			localStorage.setItem('token', user.token)
			context.commit('login', user)
		},
		logout: (context) => {
			localStorage.removeItem('token')
			context.commit('logout')
		}
	}
});