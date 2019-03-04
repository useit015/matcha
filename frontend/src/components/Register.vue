<template>
	<div class="container">
		<transition name="alert">
			<v-alert v-if="userFailed" :value="true" dismissible type="error" color="error" icon="warning" transition="scale-transition">
				Oups .. something went wrong !
			</v-alert>
			<v-alert v-if="userAdded" :value="true" dismissible type="success" color="success" icon="check_circle" transition="scale-transition">
				You have been successfully registered, please verify your email
			</v-alert>
		</transition>
		<div class="register container d-flex align-items-center justify-content-center my-5">
			<div class="card col-md-7 p-5">
				<div class="card-body">
					<h1 class="page-header text-center display-2 mb-4">Register</h1>
					<v-form v-model="valid">
						<v-text-field v-model="firstname" :rules="nameRules" label="First name" required ></v-text-field>
						<v-text-field v-model="lastname" :rules="nameRules" label="Last name" required ></v-text-field>
						<v-text-field v-model="username" :rules="usernameRules" :counter="10" label="Username" required ></v-text-field>
						<v-text-field v-model="password" :type="'password'" :counter="12" :rules="passRules" label="Password" required ></v-text-field>
						<v-text-field v-model="email" :rules="emailRules" label="E-mail" required ></v-text-field>
						<v-btn @click="submit">Submit</v-btn>
						<!-- <v-btn @click="clear">Clear</v-btn> -->
					</v-form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Register',
	data: () => ({
		valid: false,
		firstname: '',
		lastname: '',
		username: '',
		password: '',
		email: '',
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
		submit(e) {
			e.preventDefault()
			this.$http.post('http://localhost:80/matcha/public/api/user/add', {
				first_name: this.firstname,
				last_name: this.lastname,
				username: this.username,
				email: this.email,
				password: this.password
			}).then(res => {
				if (res.body && res.body.ok) {
					this.userAdded = true
					setTimeout(() => this.userAdded = false, 5000)
				} else {
					this.userAdded = false
					this.userFailed = true
					setTimeout(() => this.userFailed = false, 5000)
				}
			}).catch(err => console.error(err))
		}
	}
}
</script>

<style>
	.error--text, .theme--light.v-messages.error--text, .v-messages__message {
		color: red !important;
	}
	.v-alert.success {
		background: #4DAF50;
	}
	.v-alert.error {
		background: #FF5252;
	}
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
	.card-body {
		width: 100%;
		max-width: 40rem;
		margin: auto;
	}
</style>
