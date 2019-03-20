<template>
<v-layout column class="settings pb-5 mb-5">
	<div class="parallax"></div>
	<v-layout class="py-0 strap grey lighten-3">
		<v-container py-0>
			<v-layout>
				<v-flex xs12 sm8 md4 class="avatar">
					<v-avatar slot="offset" class="mx-auto d-block" size="200">
						<img :src="profileImage" class="avatar__img">
						<v-icon color="grey lighten-4" class="avatar__btn" @click.stop="openEditor">add_a_photo</v-icon>
					</v-avatar>
				</v-flex>
				<profile-tabs :active="activeTab" @change-tab="changeTab"></profile-tabs>
			</v-layout>
		</v-container>
	</v-layout>
	<v-container fill-height grid-list-xl class="profile">
		<v-layout justify-center wrap>
			<v-flex xs12 sm8 md4>
				<profile-badge :user="user"></profile-badge>
			</v-flex>
			<v-flex xs12 sm10 md8 class="main pa-0 grey--text">
				<profile-tabs :active="activeTab" @change-tab="changeTab" mobile></profile-tabs>
				<v-tabs-items v-model="activeTab">
					<v-tab-item value="tab-profile">
						<profile-form :user="user" @sync-user="syncUser" @update-user="updateUser"></profile-form>
					</v-tab-item>
					<v-tab-item value="tab-photo">
						<profile-gallery :images="user.images"></profile-gallery>
					</v-tab-item>
					<v-tab-item value="tab-setting">
						<profile-settings></profile-settings>
					</v-tab-item>
				</v-tabs-items>
			</v-flex>
		</v-layout>
	</v-container>
	<alert :data="alert"></alert>
	<profile-editor @update-image="updateImage" ref="profile_editor"></profile-editor>
</v-layout>
</template>

<script>
import Alert from './Alert.vue'
import ProfileForm from './ProfileForm.vue'
import ProfileTabs from './ProfileTabs.vue'
import ProfileBadge from './ProfileBadge.vue'
import ProfileEditor from './ProfileEditor.vue'
import ProfileGallery from './ProfileGallery.vue'
import ProfileSettings from './ProfileSettings.vue'
import utility from '../utility.js'
const path = require('path')

export default {
	name: 'Settings',
	components: {
		Alert,
		ProfileTabs,
		ProfileForm,
		ProfileBadge,
		ProfileEditor,
		ProfileGallery,
		ProfileSettings
	},
	data: () => ({
		activeTab: 'tab-profile',
		alert: {
			state: false,
			color: '',
			text: ''
		}
	}),
	computed: {
		user: {
			get: function () { return { ...this.$store.getters.user } },
			set: function (user) {},
		},
		profileImage() {
			return this.getFullPath(this.$store.getters.profileImage)
		}
	},
	methods: {
		...utility,
		updateUser() {
			this.$http.post(`http://localhost:80/matcha/public/api/user/update/${this.user.id}`, { ...this.user })
				.then(res => {
					if (res && res.body && res.body.ok) {
						this.showAlert('success', 'Your account has been updated successfuly')
						this.$store.dispatch('updateUser', this.user)
					}
				}).catch(err => console.error(err))
		},
		updateImage(data) {
			const fd = new FormData()
			fd.append('image', data)
			fd.append('profile', 1)
			this.$http.post(`http://localhost:80/matcha/public/api/user/image/${this.user.id}`, fd)
				.then(res => {
					if (res && res.body && res.body.ok) {
						this.showAlert('success', 'You profile image has been updated successfuly')
						this.$store.commit('updateProfileImage', res.body.name)
					}
				}).catch(err => console.error(err))
		},
		showAlert(color, text) {
			this.alert = {
				state: true,
				color,
				text
			}
		},
		syncUser(user) {
			this.user = user
		},
		changeTab(tab) {
			this.activeTab = tab
		},
		openEditor() {
			this.$refs.profile_editor.pickFile()
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

.avatar__img:hover+.avatar__btn,
.avatar__btn:hover {
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
</style>
