<template>
	<v-container>
		<transition name="alert">
			<v-alert v-if="userFailed" :value="true" dismissible type="error" color="error" icon="warning" transition="scale-transition">
				Oups .. something went wrong !
			</v-alert>
			<v-alert v-if="userAdded" :value="true" dismissible type="success" color="success" icon="check_circle" transition="scale-transition">
				You have been successfully registered, please verify your email
			</v-alert>
		</transition>
		<div class="login">
			<h1 class="page-header display-3 font-weight-light grey--text">Login</h1>
			<v-form v-model="valid" class="my-4">
				<v-text-field color="indigo" class="my-5" v-model="username" :rules="usernameRules" label="Username" required ></v-text-field>
				<v-text-field color="indigo" class="my-5" v-model="password" :rules="passRules" label="Password" required :append-icon="showPass ? 'visibility' : 'visibility_off'" :type="showPass ? 'text' : 'password'" @click:append="showPass = !showPass"></v-text-field>
				<v-btn block large depressed color="indigo" dark @click="login" class="mt-5">Login</v-btn>
				<v-layout row justify-end>
					<v-btn flat color="indigo" dark to="/register">Don't have an account? Sign up</v-btn>
				</v-layout>
			</v-form>
		</div>
	</v-container>
</template>

<script>
export default {
	name: 'Login',
	data: () => ({
		valid: false,
		showPass: false,
		username: '',
		password: '',
		userAdded: false,
		userFailed: false,
		nameRules: [
			v => !!v || 'This field is required'
		],
		usernameRules: [
			v => !!v || 'This field is required',
			v => v.length <= 10 || 'Username must be less than 10 characters'
		],
		emailRules: [
			v => !!v || 'This field is required',
			v => /.+@.+/.test(v) || 'E-mail must be valid'
		],
		passRules: [
			v => !!v || 'This field is required',
			v => /^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]+$/.test(v) || 'Password must contain at least one letter, one number and one special char',
			v => (v.length >= 8 && v.length <= 12) || 'Password must be between 8 and 12 characters long'
		]
	}),
	methods: {
		login(e) {
			e.preventDefault()
			this.$http.post('http://localhost:80/matcha/public/api/user/login', {
				username: this.username,
				password: this.password
			}).then(res => {
				console.log(res.body);
			}).catch(err => console.error(err))
		}
	}
}
</script>

<style>
	.alert-enter-active, .alert-leave-active, .register {
		transition: all .5s;
	}
	.alert-enter, .alert-leave-to {
		opacity: 0;
	}
	.register>.card {
		box-shadow: 0 15px 30px 0 rgba(0,0,0,0.11),
					0 5px 15px 0 rgba(0,0,0,0.08);
		text-align: center;
	}
	.login {
		width: 100%;
		max-width: 40rem;
		margin: auto;
	}
</style>
