<?php

class Session {
	public static function create($user) {
		$_SESSION['user_id'] = $user->id;
		$_SESSION['user_firstname'] = $user->first_name;
		$_SESSION['user_lastname'] = $user->last_name;
		$_SESSION['user_username'] = $user->username;
		$_SESSION['user_email'] = $user->email;
		$_SESSION['token'] = bin2hex(random_bytes(32));
	}

	public static function destroy() {
		unset($_SESSION['user_id']);
		unset($_SESSION['user_firstname']);
		unset($_SESSION['user_lastname']);
		unset($_SESSION['user_username']);
		unset($_SESSION['user_email']);
		unset($_SESSION['token']);
		session_destroy();
	}
}