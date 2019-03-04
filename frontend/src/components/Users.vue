<template>
	<div class="users container">
		<h1 class="page-header">All users</h1>
		<ul>
			<li v-for="user in users">
				{{ user }}
			</li>
		</ul>
	</div>
</template>

<script>
export default {
	name: 'Users',
	data () {
		return {
			users: []
		}
	},
	methods: {
		fetchUsers(){
			this.$http.get('http://localhost:80/matcha/public/api/users')
				.then(res => this.users = res.body)
				.catch(err => console.error(err))
		}
	},
	created: function(){
		this.fetchUsers()
	}
}
</script>

<style scoped>

</style>
