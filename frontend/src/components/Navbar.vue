<template>
	<nav>
		<v-toolbar flat app>
			<v-toolbar-side-icon class="grey--text" @click="drawer = !drawer"></v-toolbar-side-icon>
			<v-toolbar-title class="text-uppercase grey--text">
				<span>M</span><span class="font-weight-light">atcha</span>
			</v-toolbar-title>
			<v-spacer></v-spacer>
			<v-btn flat color="grey" router to="/login">Login</v-btn>
			<v-btn flat color="grey" router to="/register">Sign Up</v-btn>
		</v-toolbar>
		<v-navigation-drawer v-model="drawer" app class="indigo">
			<v-list>
				<v-list-tile v-for="link in links" :key="link.text" router :to="link.route">
					<v-list-tile-action>
						<v-icon class="white--text">{{ link.icon }}</v-icon>
					</v-list-tile-action>
					<v-list-tile-content>
						<v-list-tile-title class="white--text">{{ link.text }}</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
			</v-list>
		</v-navigation-drawer>
	</nav>
</template>

<script>
export default {
	name: 'Navbar',
	data () {
		return {
			drawer: false,
			links: [
				{
					icon: 'dashboard',
					text: 'Home',
					route: '/',
				},
				{
					icon: 'folder',
					text: 'About',
					route: '/about',
				},
				{
					icon: 'person',
					text: 'Register',
					route: '/register',
				},
			]
		}
	}
}
</script>

<style scoped>

</style>
