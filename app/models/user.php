<?php

class User {
	private $db;

	public function __construct() {
		$this->db = new Database();
	}

	public function checkToken($token) {
		$this->db->query('SELECT * FROM users WHERE token = ? AND TIME_TO_SEC(TIMEDIFF(tokenExpiration, NOW())) > 0');
		return $this->db->single([$token]);
	}

	public function setToken($data) {
		$this->db->query('UPDATE users SET token = :token, tokenExpiration = :tokenExpiration WHERE id = :id');
		return $this->db->execute($data);
	}

	public function login($username, $password) {
		$this->db->query('SELECT * FROM users WHERE username = ? AND verified = 1');
		$row = $this->db->single([$username]);
		return password_verify($password, $row->password) ? $row : false;
	}

	public function getAllUsers() {
		$this->db->query('SELECT * FROM users');
		return $this->db->resultSet([]);
	}

	public function getUser($id) {
		$this->db->query('SELECT * FROM users WHERE id = ?');
		$row = $this->db->single([$id]);
		return $row ? [$row] : [];
	}

	public function addUser($data) {
		$this->db->query('INSERT INTO users
							(first_name, last_name, username, email, password, vkey)
						VALUES
							(:first_name, :last_name, :username, :email, :password, :vkey)');
		return $this->db->execute($data);
	}

	public function updateUser($data) {
		$this->db->query('UPDATE users SET
						first_name = :first_name,
						last_name = :last_name,
						username = :username,
						email = :email,
						gender = :gender,
						sex_preference = :sex_preference,
						biography = :biography,
						tags = :tags,
						`address` = :address,
						phone = :phone
					WHERE id = :id');
		return $this->db->execute($data);
	}

	public function verifyUser($vkey) {
		$this->db->query('UPDATE users SET verified = 1 WHERE vkey = ? AND verified = 0');
		return $this->db->execute([$vkey]);
	}

	public function deleteUser($id) {
		$this->db->query('DELETE FROM users WHERE id = ?');
		return $this->db->execute([$id]);
	}

	public function isUser($id) {
		$this->db->query('SELECT * FROM users WHERE id = ?');
		$this->db->execute([$id]);
		return $this->db->rowCount() !== 0;
	}

	public function isVerified($vkey) {
		$this->db->query('SELECT verified FROM users WHERE vkey = ?');
		return $this->db->single([$vkey]);
	}

}