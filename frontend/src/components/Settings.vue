<template>
	<v-layout column class="settings">
		<div class="parallax"></div>
		<v-layout class="py-0 strap grey lighten-3">
			<v-container py-0>
				<v-layout>
					<v-flex xs12 md4 class="avatar mr-auto">
						<v-avatar slot="offset" class="mx-auto d-block" size="200">
							<img src="../assets/handsome.jpeg" class="avatar__img">
						</v-avatar>
					</v-flex>
					<v-btn large flat round color="grey" class="strap__btn hidden-sm-and-down" @click="activeTab = 'profile'">
						<v-icon left>person</v-icon>
						<span class="hidden-md-and-down">Profile</span>
					</v-btn>
					<v-btn large flat round color="grey" class="strap__btn hidden-sm-and-down" @click="activeTab = 'pictures'">
						<v-icon left>photo_camera</v-icon>
						<span class="hidden-md-and-down">Pictures</span>
					</v-btn>
					<v-btn large flat round color="grey" class="strap__btn hidden-sm-and-down" @click="activeTab = 'settings'">
						<v-icon left>settings</v-icon>
						<span class="hidden-md-and-down">Preferences</span>
					</v-btn>
				</v-layout>
			</v-container>
		</v-layout>
		<div class="profile">
			<v-container fill-height grid-list-xl pt-0>
				<v-layout justify-center wrap>
					<v-flex xs12 sm8 md4>
						<v-container py-0>
							<v-card-text class="text-xs-center">
								<h2 class="title text-capitalize font-weight-light mb-2">{{ `${user.first_name} ${user.last_name}` }}</h2>
								<h3 class="subheading text-capitalize font-weight-thin mb-3">{{ `@${user.username}` }}</h3>
								<p class="card-description font-weight-light">{{ user.biography }}</p>
							</v-card-text>
						</v-container>
					</v-flex>
					<v-flex xs12 md8 class="main pa-0 grey--text">
						<v-container py-0>
							<v-layout justify-center wrap class="hidden-md-and-up pt-5">
								<v-btn large flat round color="grey" class="strap__btn" @click="activeTab = 'profile'">
									<v-icon>person</v-icon>
								</v-btn>
								<v-btn large flat round color="grey" class="strap__btn" @click="activeTab = 'pictures'">
									<v-icon>photo_camera</v-icon>
								</v-btn>
								<v-btn large flat round color="grey" class="strap__btn" @click="activeTab = 'settings'">
									<v-icon>settings</v-icon>
								</v-btn>
							</v-layout>
						</v-container>
						<v-form v-if="activeTab == 'profile'">
							<v-container>
								<h1 class="heading display-2 text-xs-center text-md-left font-weight-thin pt-4 pb-3 mb-4">Account Informations</h1>
								<v-layout wrap>
									<v-flex xs12 md4>
										<v-text-field label="First Name" color="indigo" v-model="user.first_name"/>
									</v-flex>
									<v-flex xs12 md4>
										<v-text-field label="Last Name" color="indigo" v-model="user.last_name"/>
									</v-flex>
									<v-flex xs12 md4>
										<v-text-field color="indigo" label="Username" v-model="user.username"/>
									</v-flex>
									<v-flex xs12 md6>
										<v-text-field label="Phone number" color="indigo" v-model="user.phone"/>
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
									<v-flex xs12 md6>
										<v-select color="indigo" :items="genders" label="Gender" v-model="user.gender"></v-select>
									</v-flex>
									<v-flex xs12 md6>
										<v-select color="indigo" :items="looking" label="Looking for" v-model="user.looking"></v-select>
									</v-flex>
									<v-flex xs12>
										<vue-tags-input v-model="tag" :tags="tags" @tags-changed="newTags => tags = newTags"/>
									</v-flex>
									<v-flex xs12>
										<v-textarea color="indigo" label="Bio" v-model="user.biography"/>
									</v-flex>
									<v-flex xs12 text-xs-right>
										<v-btn class="mx-0 font-weight-light" color="indigo" large block dark @click.prevent="updateUser">Update Profile</v-btn>
									</v-flex>
								</v-layout>
							</v-container>
						</v-form>
						<v-container fluid grid-list-sm v-if="activeTab == 'pictures'">
							<h1 class="heading display-2 text-xs-center text-md-left font-weight-thin pt-4 pb-3 mb-4">Pictures</h1>
							<v-layout row wrap>
								<v-flex v-for="i in 9" :key="i" xs4>
									<img :src="`https://randomuser.me/api/portraits/men/${i + 40}.jpg`" class="image" alt="lorem" width="100%" height="100%">
								</v-flex>
							</v-layout>
						</v-container>
					</v-flex>
				</v-layout>
			</v-container>
		</div>
	</v-layout>
</template>

<script>
import { VueTagsInput, createTags } from '@johmun/vue-tags-input'
export default {
	name: 'Settings',
	components: { VueTagsInput },
	data: () => ({
		tag: '',
		tags: [],
		genders: ['male', 'female'],
		looking: ['male', 'female', 'both'],
		activeTab: 'profile',
	}),
	computed: {
		user() {
			return { ...this.$store.getters.user }
		}
	},
	watch: {
		user: {
			handler: 'fetchUser',
			immediate: true
		},
		tags: function() {
			this.$store.commit('updateTags', this.tags)
		}
	},
	methods: {
		fetchUser() {
			const list = this.user.tags ? this.user.tags.split(',') : []
			this.tags = list ? createTags(list) : []
		},
		updateUser() {
			this.$http.post(`http://localhost:80/matcha/public/api/user/update/${this.user.id}`, { ...this.user })
				.then(res => res.body ? res.body.ok ? this.$store.dispatch('updateUser', this.user) : 1 : 1)
				.catch(err => console.error(err))
		}
	}
}
</script>

<style>
.heading {
	border-bottom: 1px solid #999;
}

.parallax {
	background-image: url(https://images.pexels.com/photos/96422/pexels-photo-96422.jpeg);
	background-position: center;
	background-size: cover;
	height: 25rem;
	width: 100%;
	background-attachment: fixed;
	background-repeat: no-repeat;
}

.strap {
	height: 4rem;
}

.avatar {
	transform: translateY(-8rem);
}

.avatar__img {
	box-shadow: 0 0 0 3px #f5f5f5,
				0 1px 5px rgba(0, 0, 0, .2);
}

.profile {
	padding-top: 4.5rem;
}

.main {
	margin-top: -2.75rem;
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
	height: 1.5px;
	background: var(--color-primary);
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
