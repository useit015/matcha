<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->options('/{routes:.+}', function ($req, $res, $args) {
	return $res;
});

$app->add(function ($req, $res, $next) {
	$response = $next($req, $res);
	return $response
			->withHeader('Access-Control-Allow-Origin', '*')
			->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
			->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->get('/api/users', function(Request $req, Response $res) {
	$db = new Database();
	$db->query('SELECT * FROM users');
	echo json_encode($db->resultSet([]));
});

$app->get('/api/user/{id}', function(Request $req, Response $res) {
	$db = new Database();
	$db->query('SELECT * FROM users WHERE id = ?');
	$row = $db->single([$req->getAttribute('id')]);
	echo json_encode($row ? [$row] : []);
});

$app->post('/api/user/add', function(Request $req, Response $res) {
	$val = new Validator();
	$data = [
		'first_name' => $req->getParam('first_name'),
		'last_name' => $req->getParam('last_name'),
		'username' => $req->getParam('username'),
		'email' => $req->getParam('email'),
		'password' => $req->getParam('password'),
		'vkey' => bin2hex(random_bytes(10))
	];
	$err = [
		'username' => $val->validateName($data['username'], 'User'),
		'password' => $val->validatePassword($data['password']),
		'email' => $val->validateEmail($data['email'])
	];
	if (!empty($err['username']) || !empty($err['password']) || !empty($err['email']))
		die(json_encode(['response' => $err, 'errors' => true]));
	$db = new Database();
	$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
	$db->query('INSERT INTO users
					(first_name, last_name, username, email, `password`, vkey)
				VALUES
					(:first_name, :last_name, :username, :email, :password, :vkey)');
	if ($db->execute($data)) {
		mail($data['email'], 'Mail verification','http://localhost/matcha/public/api/user/verify/' . $data['vkey']);
		echo json_encode(['response' => $data, 'errors' => false]);
	} else
		echo json_encode([]);
});

$app->get('/api/user/verify/{vkey}', function(Request $req, Response $res) {
	$vkey = $req->getAttribute('vkey');
	$db = new Database();
	$db->query('SELECT verified FROM users WHERE vkey = ?');
	$row = $db->single([$vkey]);
	if ($row) {
		if ($row->verified == 1)
			die('Already verified');
	} else
		die('Oups! Something went wrong.');
	$db->query('UPDATE users SET verified = 1 WHERE vkey = ? AND verified = 0');
	if ($db->execute([$vkey]))
		echo 'done';
	else
		echo 'none';
});

$app->post('/api/user/update/{id}', function(Request $req, Response $res) {
	$data = [
		'id' => $req->getAttribute('id'),
		'first_name' => $req->getParam('first_name'),
		'last_name' => $req->getParam('last_name'),
		'username' => $req->getParam('username'),
		'email' => $req->getParam('email'),
		'gender' => $req->getParam('gender'),
		'sex_preference' => $req->getParam('sex_preference'),
		'biography' => $req->getParam('biography'),
		'tags' => $req->getParam('tags'),
		'address' => $req->getParam('address'),
		'phone' => $req->getParam('phone')
	];
	$db = new Database();
	$db->query('SELECT * FROM users WHERE id = ?');
	$db->execute([$data['id']]);
	if (!$db->rowCount())
		die(json_encode([]));
	$db->query('UPDATE users SET
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
	if ($db->execute($data))
		echo json_encode($data);
	else
		echo json_encode([]);
	});

$app->post('/api/user/delete/{id}', function(Request $req, Response $res) {
	$id = $req->getAttribute('id');
	$db = new Database();
	$db->query('SELECT * FROM users WHERE id = ?');
	$db->execute([$id]);
	if (!$db->rowCount())
		die(json_encode([]));
	$db->query('DELETE FROM users WHERE id = ?');
	if ($db->execute([$id]))
		echo json_encode($id);
	else
		echo json_encode([]);
});
