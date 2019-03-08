<template>
	<div>
		<img width="100%" height="300" src="https://visme.co/blog/wp-content/uploads/2017/07/50-Beautiful-and-Minimalist-Presentation-Backgrounds-05.jpg"/>
		<v-flex xs12 md4 class="profile">
			<v-container py-0>
				<v-avatar slot="offset" class="mx-auto d-block" size="200">
					<img src="../assets/handsome.jpeg">
				</v-avatar>
				<v-card-text class="text-xs-center">
					<h2 class="card-title font-weight-light">{{ `${user.first_name} ${user.last_name}` }}</h2>
					<p class="card-description font-weight-light">{{ user.biography }}</p>
					<v-btn color="indigo" dark round class="font-weight-light">Follow</v-btn>
				</v-card-text>
			</v-container>
		</v-flex>
		<v-container fill-height fluid grid-list-xl>
			<v-layout justify-end wrap>
				<v-flex xs12 md8>
					<v-form>
						<v-container py-0>
							<v-layout wrap>
								<v-flex xs12 md6>
									<v-text-field label="First Name" color="indigo" v-model="user.first_name"/>
								</v-flex>
								<v-flex xs12 md6>
									<v-text-field label="Last Name" color="indigo" v-model="user.last_name"/>
								</v-flex>
								<v-flex xs12 md6>
									<v-text-field color="indigo" label="Username" v-model="user.username"/>
								</v-flex>
								<v-flex xs12 md6>
									<v-text-field label="Email Address" color="indigo" v-model="user.email" disabled/>
								</v-flex>
								<v-flex xs12 md12>
									<v-text-field label="Address" color="indigo" v-model="user.address"/>
								</v-flex>
								<v-flex xs12 md4>
									<v-text-field label="City" color="indigo" v-model="user.city"/>
								</v-flex>
								<v-flex xs12 md4>
									<v-text-field label="Country" color="indigo" v-model="user.country"/>
								</v-flex>
								<v-flex xs12 md4>
									<v-text-field color="indigo" label="Postal Code" type="number" v-model="user.postal_code"/>
								</v-flex>
								<v-flex xs12>
									<vue-tags-input v-model="tag" :tags="tags" @tags-changed="newTags => tags = newTags"/>
								</v-flex>
								<v-flex xs12>
									<v-textarea color="indigo" label="Bio" v-model="user.biography"/>
								</v-flex>
								<v-flex xs12 text-xs-right>
									<v-btn class="mx-0 font-weight-light" color="indigo" dark>Update Profile</v-btn>
								</v-flex>
							</v-layout>
						</v-container>
					</v-form>
				</v-flex>
			</v-layout>
		</v-container>
	</div>
</template>

<script>
import { VueTagsInput, createTags } from '@johmun/vue-tags-input';
export default {
	name: 'Settings',
	components: { VueTagsInput },
	data: () => ({
		tag: '',
		tags: [],
		firstname: '',
		lastname: '',
		username: '',
		password: '',
		passwordConfirm: '',
		email: '',
		valid: false,
		showPass: false,
		showConfPass: false,
		userAdded: false,
		userFailed: false,
		rules: {
			name: [
				v => !!v || 'This field is required'
			],
			username: [
				v => !!v || 'This field is required',
				v => v.length <= 10 || 'Username must be less than 10 characters'
			],
			email: [
				v => !!v || 'This field is required',
				v => /.+@.+/.test(v) || 'E-mail must be valid'
			],
			password: [
				v => !!v || 'This field is required',
				v => /^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]+$/.test(v) || 'Password must contain at least one letter, one number and one special char',
				v => (v.length >= 8 && v.length <= 12) || 'Password must be between 8 and 12 characters long'
			]
		}
	}),
	computed: {
		user() {
			return this.$store.getters.user;
		}
	},
	methods: {
		
	},
	created: function() {
		const list = this.$store.getters.user.tags.split(',')
		this.tags = createTags(list)
	}
}
</script>

<style>
.profile {
	position: absolute;
	transform: translateY(-110px);
}

.vue-tags-input {
	background: transparent !important;
	max-width: 100% !important;
	font-size: 1.2em;
}

.vue-tags-input .ti-input::after {
	content: '';
	display: block;
	position: absolute;
	bottom: 0;
	left: 50%;
	transform: translate(-50%, 25%);
	width: 0;
	height: 2.5px;
	background: #3f51b5;
	transition: width .2s ease-in-out;
}

.vue-tags-input.ti-focus .ti-input::after {
	width: 100%;
}

.vue-tags-input .ti-input {
	border: none;
	border-bottom: 1px solid grey;
}
</style>

