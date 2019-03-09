<template>
	<div>
		<img width="100%" height="300" src="https://visme.co/blog/wp-content/uploads/2017/07/50-Beautiful-and-Minimalist-Presentation-Backgrounds-05.jpg"/>
		<div class="profile">
			<v-flex xs12 md4>
				<v-container py-0>
					<v-avatar slot="offset" class="mx-auto d-block" size="200">
						<img src="../assets/handsome.jpeg">
					</v-avatar>
				</v-container>
			</v-flex>
			<v-container fill-height fluid grid-list-xl pt-0>
				<v-layout justify-center wrap>
					<v-flex xs12 sm8 md4>
						<v-container py-0>
							<v-card-text class="text-xs-center">
								<h2 class="card-title text-capitalize font-weight-light">{{ `${user.first_name} ${user.last_name}` }}</h2>
								<p class="card-description font-weight-light">{{ user.biography }}</p>
							</v-card-text>
						</v-container>
					</v-flex>
					<v-flex xs12 md8 class="main pa-0">
						<v-tabs grow centered icons-and-text color="grey lighten-5">
							<v-tabs-slider color="indigo"></v-tabs-slider>
							<v-tab href="#tab-1">
								<span>Profile</span>
								<v-icon>account_circle</v-icon>
							</v-tab>
							<v-tab href="#tab-2">
								<span>Pictures</span>
								<v-icon>photo_camera</v-icon>
							</v-tab>
							<v-tab href="#tab-3">
								<span>Account</span>
								<v-icon>lock</v-icon>
							</v-tab>
							<v-tab-item v-for="i in 3" :key="i" :value="'tab-' + i" >
								<v-card flat class="grey lighten-5">
									<v-card-text class="px-1">
										<v-form>
											<v-container px-0>
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
													<v-flex xs12>
														<vue-tags-input v-model="tag" :tags="tags" @tags-changed="newTags => tags = newTags"/>
													</v-flex>
													<v-flex xs12>
														<v-textarea color="indigo" label="Bio" v-model="user.biography"/>
													</v-flex>
													<v-flex xs12 text-xs-right>
														<v-btn class="mx-0 font-weight-light" color="indigo" dark @click.prevent="updateUser">Update Profile</v-btn>
													</v-flex>
												</v-layout>
											</v-container>
										</v-form>
									</v-card-text>
								</v-card>
							</v-tab-item>
						</v-tabs>
					</v-flex>
				</v-layout>
			</v-container>
		</div>
	</div>
</template>

<script>
import { VueTagsInput, createTags } from '@johmun/vue-tags-input'
export default {
	name: 'Settings',
	components: { VueTagsInput },
	data: () => ({
		tag: '',
		tags: []
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
				.then(res => res.body.ok ? this.$store.dispatch('updateUser', this.user) : 1)
				.catch(err => console.error(err))
		}
	}
}
</script>

<style>
.profile {
	transform: translateY(-110px);
}

.main {
	transform: translateY(-85px);
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

