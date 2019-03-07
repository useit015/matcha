<template>
	<v-container class="mt-4">
		<div class="settings">
			<!-- <h1 class="display-2 font-weight-thin">Account Informations</h1> -->
			<v-layout justify-center align-center>
				<v-avatar size="180" color="grey lighten-4">
					<img src="https://vuetifyjs.com/apple-touch-icon-180x180.png" alt="avatar">
				</v-avatar>
			</v-layout>
			<h1 class="page-header display-3 mb-4 font-weight-light grey--text">Profile</h1>
			<v-form v-model="valid" class="my-4">
				<v-text-field color="indigo" class="my-3" required ></v-text-field>
				<v-text-field color="indigo" class="my-3" required ></v-text-field>
				<v-text-field color="indigo" class="my-3" required ></v-text-field>
				<v-text-field color="indigo" class="my-3" required ></v-text-field>
				<v-text-field color="indigo" class="my-3" required ></v-text-field>
				<v-text-field color="indigo" class="my-3" required ></v-text-field>
				<v-btn block large depressed color="indigo" dark class="mt-5">Update</v-btn>
				<v-layout row justify-end>
					<v-btn flat color="indigo" dark to="/login">Have an account? Login</v-btn>
				</v-layout>
			</v-form>
		</div>
	</v-container>
</template>

<script>
export default {
	name: 'Settings',
	data() {
		return {

		}
	},
	methods: {
		
	}
}
</script>

<style scoped>

</style>
