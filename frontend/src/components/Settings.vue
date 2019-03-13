<template>
	<v-layout column class="settings pb-5 mb-5">
		<div class="parallax"></div>
		<v-layout class="py-0 strap grey lighten-3">
			<v-container py-0>
				<v-layout>
					<v-flex xs12 md4 class="avatar">
						<v-avatar slot="offset" class="mx-auto d-block" size="200">
							<img :src="profileImage" class="avatar__img">
							<v-icon color="grey lighten-4" class="avatar__btn" @click.stop="pickFile">add_a_photo</v-icon>
						</v-avatar>
					</v-flex>
					<v-flex md8 class="hidden-sm-and-down">
						<v-tabs fixed-tabs centered v-model="model" color="grey lighten-3" slider-color="indigo">
							<v-tab href="#tab-profile">
								<v-icon left>person</v-icon>
								<span>Profile</span>
							</v-tab>
							<v-tab href="#tab-photo">
								<v-icon left>photo_camera</v-icon>
								<span>Pictures</span>
							</v-tab>
							<v-tab href="#tab-setting">
								<v-icon left>settings</v-icon>
								<span>Preferences</span>
							</v-tab>
						</v-tabs>
					</v-flex>
				</v-layout>
			</v-container>
		</v-layout>
		<div class="profile">
			<v-container fill-height grid-list-xl pt-0>
				<v-layout justify-center wrap>
					<v-flex xs12 sm8 md4>
						<v-container py-0>
							<h2 class="title text-capitalize mb-2">{{ `${user.first_name} ${user.last_name}` }}</h2>
							<h4 class="font-weight-thin mb-2">{{ `@${user.username}` }}</h4>
							<p class="mb-3">{{ user.biography }}</p>
							<p class="font-weight-light mb-2">
								<v-icon small>calendar_today</v-icon>
								<span class="ml-2">{{ `Joined ${formatDate(user.created_at, false)}` }}</span>
							</p>
							<p v-if="user.birthdate" class="font-weight-light">
								<v-icon small>child_care</v-icon>
								<span class="ml-2">{{ `Born ${formatDate(user.birthdate, true)}` }}</span>
							</p>
						</v-container>
					</v-flex>
					<v-flex xs12 sm10 md8 class="main pa-0 grey--text">
						<v-flex md8 class="hidden-md-and-up pb-0">
							<v-tabs fixed-tabs centered v-model="model" color="grey lighten-5" slider-color="indigo">
								<v-tab href="#tab-profile">
									<v-icon>person</v-icon>
									<span class="pl-3 hidden-xs-only">Profile</span>
								</v-tab>
								<v-tab href="#tab-photo">
									<v-icon>photo_camera</v-icon>
									<span class="pl-3 hidden-xs-only">Pictures</span>
								</v-tab>
								<v-tab href="#tab-setting">
									<v-icon>settings</v-icon>
									<span class="pl-3 hidden-xs-only">Preferences</span>
								</v-tab>
							</v-tabs>
						</v-flex>
						<v-tabs-items v-model="model">
							<v-tab-item value="tab-profile">
								<v-form>
									<v-container>
										<h1 class="heading display-2 text-xs-center text-md-left font-weight-thin pt-4 pb-3 mb-4 hidden-sm-and-down">Account Informations</h1>
										<v-layout wrap>
											<v-flex xs12>
												<v-text-field color="indigo" label="Username" v-model="user.username"/>
											</v-flex>
											<v-flex xs12 md6>
												<v-text-field label="First Name" color="indigo" v-model="user.first_name"/>
											</v-flex>
											<v-flex xs12 md6>
												<v-text-field label="Last Name" color="indigo" v-model="user.last_name"/>
											</v-flex>
											<v-flex xs12 md6>
												<v-text-field label="Phone Number" color="indigo" v-model="user.phone"/>
											</v-flex>
											<v-flex xs12 md6>
												<v-menu v-model="menu" :close-on-content-click="false" :nudge-right="40" lazy transition="scale-transition" offset-y full-width min-width="290px">
													<template v-slot:activator="{ on }">
														<v-text-field color="indigo" :value="formatDate(user.birthdate, true)" label="Birth Date" readonly v-on="on"></v-text-field>
													</template>
													<v-date-picker color="indigo" v-model="user.birthdate" @input="menu = false"></v-date-picker>
												</v-menu>
											</v-flex>
											<v-flex xs12 md6>
												<v-select color="indigo" :items="genders" label="Gender" v-model="user.gender"></v-select>
											</v-flex>
											<v-flex xs12 md6>
												<v-select color="indigo" :items="looking" label="Looking For" v-model="user.looking"></v-select>
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
												<v-btn class="mx-0 font-weight-light" color="indigo" large dark @click.prevent="updateUser">Save</v-btn>
											</v-flex>
										</v-layout>
									</v-container>
								</v-form>
							</v-tab-item>
							<v-tab-item value="tab-photo">
								<v-container fluid grid-list-sm pt-0>
									<h1 class="heading display-2 text-xs-center text-md-left font-weight-thin pt-4 pb-3 mb-4 hidden-sm-and-down">Pictures</h1>
									<v-layout row wrap>
										<v-flex v-for="image in user.images" :key="image.id" xs4 grow>
											<img :src="`http://localhost:80/matcha/uploads/${image.name}`" class="image" width="100%" height="100%">
										</v-flex>
									</v-layout>
								</v-container>
							</v-tab-item>
							<v-tab-item value="tab-setting">
								<v-card flat>
									<v-card-text>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate consequatur odit suscipit reiciendis veritatis magni facilis nesciunt natus fuga incidunt.</v-card-text>
								</v-card>
							</v-tab-item>
						</v-tabs-items>
					</v-flex>
				</v-layout>
			</v-container>
		</div>
		<v-snackbar v-model="alert.state" :color="alert.color" multi-line :timeout="4000" auto-height top right>
			{{ alert.text }} 
			<v-btn dark flat @click="alert.state = false">Close</v-btn>
		</v-snackbar>
		<v-dialog v-model="dialog" max-width="500" persistent>
			<v-card class="grey lighten-3">
				<v-layout column align-center justify-center pt-4>
					<vue-avatar :width=400 :height=400 :border=0 ref="vueavatar" @vue-avatar-editor:image-ready="onImageReady" class="mb-3"></vue-avatar>
					<vue-avatar-scale ref="vueavatarscale" @vue-avatar-editor-scale:change-scale="onChangeScale" :width=250 :min=1 :max=3 :step=0.02></vue-avatar-scale>
				</v-layout>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn flat color="indigo" @click="dialog = false">Cancel</v-btn>
					<v-btn flat color="indigo" @click="saveClicked">Save</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</v-layout>
</template>

<script>
import { VueTagsInput, createTags } from '@johmun/vue-tags-input'
import VueAvatar from './VueAvatar.vue'
import VueAvatarScale from './VueAvatarScale.vue'

const path = require('path')
export default {
	name: 'Settings',
	components: {
		VueTagsInput,
		VueAvatar,
		VueAvatarScale
	},
	data: () => ({
		dialog: false,
		uploading: false,
		tmpImage: '',
		menu: false,
		model: 'tab-profile',
		tag: '',
		tags: [],
		genders: ['male', 'female'],
		looking: ['male', 'female', 'both'],
		selectedImage: null,
		alert: {
			state: false,
			color: '',
			text: ''
		}
	}),
	computed: {
		user() {
			return { ...this.$store.getters.user }
		},
		profileImage() {
			if (!this.uploading && this.user.images)
				return `http://localhost:80/matcha/uploads/${this.$store.getters.profileImage}`
		}
	},
	watch: {
		user: {
			handler: 'fetchUser',
			immediate: true
		},
		tags: function() {
			this.user.tags = this.tags.map(cur => cur.text.toLowerCase()).join(',')
		}
	},
	methods: {
		fetchUser() {
			const list = this.user.tags ? this.user.tags.split(',') : []
			this.tags = list ? createTags(list) : []
		},
		updateUser() {
			this.$http.post(`http://localhost:80/matcha/public/api/user/update/${this.user.id}`, { ...this.user })
				.then(res => {
					if (res && res.body && res.body.ok) {
						this.showAlert('success', 'You info has been updated successfuly')
						this.$store.dispatch('updateUser', this.user)
						this.uploading = false
					}
				}).catch(err => console.error(err))
		},
		pickFile() {
			this.$refs.vueavatar.clicked()
			this.dialog = true
		},
		uploadImage(data) {
			const fd = new FormData()
			fd.append('image', data)
			fd.append('profile', 1)
			this.$http.post(`http://localhost:80/matcha/public/api/user/image/${this.user.id}`, fd)
				.then(res => {
					if (res && res.body && res.body.ok) {
						this.showAlert('success', 'You profile image has been updated successfuly')
						this.$store.commit('updateProfileImage', res.body.name)
						this.uploading = false
					}
				}).catch(err => console.error(err))
		},
		formatDate(date, long) {
			if (!date) return ''
			const d = new Date(date)
			const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
			if (long)
				return `${months[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}`
			return `${months[d.getMonth()]} ${d.getFullYear()}`
		},
		showAlert(color, text) {
			this.alert = {
				state: true,
				color,
				text
			}
		},
		onChangeScale (scale) {
			this.$refs.vueavatar.changeScale(scale)
		},
		saveClicked(){
			const img = this.$refs.vueavatar.getImageScaled().toDataURL()
			this.uploadImage(img)
			this.$refs.vueavatarscale.reset()
			this.dialog = false
		},
		onImageReady(scale){
			this.$refs.vueavatarscale.setScale(scale)
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

.strap, .v-tabs__container {
	height: 4rem;
}

.avatar {
	transform: translateY(-8rem);
	position: relative;
}

.avatar__btn {
	position: absolute;
	top: 100px;
	left: 50%;
	transform: translate(-50%, 0) scale(0);
	opacity: 0;
	cursor: pointer;
	transition: all .4s .1s ease;
	font-size: 5rem;
}

.avatar__img:hover + .avatar__btn, .avatar__btn:hover {
	transform: translate(-50%, -50%) scale(1);
	opacity: 1;
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

.flex.xs4.grow {
	max-width: 100% !important;
}

.v-tabs__item--active, .v-tabs__item--active>.v-icon {
	color: var(--color-primary) !important;
}

.v-snack__content {
	padding: .75rem 1.5rem !important;
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

.cropper {
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
}
</style>
