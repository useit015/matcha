<?php

class Session {
	public static function create($user) {
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['user_email'] = $user['email'];
		$_SESSION['user_firstname'] = $user['firstname'];
		$_SESSION['user_lastname'] = $user['lastname'];
		$_SESSION['token'] = bin2hex(random_bytes(32));
	}

	public static function update($data) {
		$_SESSION['user_email'] = $data['email'];
		$_SESSION['user_name'] = $data['name'];
		$_SESSION['user_img'] = $data['image'];
		$_SESSION['user_notif'] = $data['notif'];
		$_SESSION['user_nbr'] = $data['number'];
		$_SESSION['token'] = bin2hex(random_bytes(32));
	}

	public static function destroy() {
		unset($_SESSION['user_id']);
		unset($_SESSION['user_email']);
		unset($_SESSION['user_firstname']);
		unset($_SESSION['user_lastname']);
		unset($_SESSION['token']);
		session_destroy();
	}
}