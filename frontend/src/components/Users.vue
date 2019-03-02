<template>
	<div class="users container">
		<h1 class="page-header">All users</h1>
	</div>
</template>

<script>
export default {
	name: 'Users',
	data () {
		return {
			customers: []
		}
	},
	methods: {
		fetchUsers(){
			this.$http.get('http://localhost/matcha/public/api/users')
				.then(res => console.log(res.body))
		}
	},
	created: function(){
		this.fetchUsers()
	}
}
</script>

<style scoped>

</style>
