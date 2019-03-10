<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App([
	'settings' => [
		'displayErrorDetails' => true
	]
]);

$app->post('/api/user/login', function(Request $req, Response $res) {
	$userModel = new User();
	$loggedIn = $userModel->login($req->getParam('username'), $req->getParam('password'));
	if ($loggedIn) {
		$loggedIn->token = bin2hex(random_bytes(8));
		$loggedIn->tokenExpiration = date('Y-m-d H:i:s', strtotime('+2 hour'));
		$userModel->setToken([
			'token' => $loggedIn->token,
			'tokenExpiration' => $loggedIn->tokenExpiration,
			'id' => $loggedIn->id
		]);
	}
	return $res->withJson($loggedIn);
});

$app->post('/api/user/isloggedin', function(Request $req, Response $res) {
	$userModel = new User();
	$loggedIn = $userModel->checkToken($req->getParam('token'));
	if ($loggedIn) {
		$loggedIn->token = bin2hex(random_bytes(8));
		$loggedIn->tokenExpiration = date('Y-m-d H:i:s', strtotime('+2 hour'));
		$userModel->setToken([
			'token' => $loggedIn->token,
			'tokenExpiration' => $loggedIn->tokenExpiration,
			'id' => $loggedIn->id
		]);
	}
	return $res->withJson($loggedIn);
});

$app->post('/api/user/logout', function(Request $req, Response $res) {
	return $res->withJson(['ok' => true]);
});

$app->get('/api/users', function(Request $req, Response $res) {
	$userModel = new User();
	return $res->withJson($userModel->getAllUsers());
});

$app->get('/api/user/{id}', function(Request $req, Response $res) {
	$userModel = new User();
	echo json_encode($userModel->getUser($req->getAttribute('id')));
});

$app->post('/api/user/add', function(Request $req, Response $res) {
	$userModel = new User();
	$validator = new Validator();
	$data = [
		'first_name' => $req->getParam('first_name'),
		'last_name' => $req->getParam('last_name'),
		'username' => $req->getParam('username'),
		'email' => $req->getParam('email'),
		'password' => $req->getParam('password'),
		'vkey' => bin2hex(random_bytes(10))
	];
	$err = [
		'username' => $validator->validateName($data['username'], 'User'),
		'password' => $validator->validatePassword($data['password']),
		'email' => $validator->validateEmail($data['email'])
	];
	$res = [
		'response' => $data,
		'err' => '',
		'ok' => true
	];
	if (empty($err['username']) && empty($err['password']) && empty($err['email'])) {
		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		if ($userModel->addUser($data)) {
			mail($data['email'], 'Mail verification','http://localhost/matcha/public/api/user/verify/' . $data['vkey']);
		} else {
			$res['err'] = ['server' => 'Cant add user ..'];
			$res['ok'] = false;
		}
	} else {
		$res['err'] = $err;
		$res['ok'] = false;
	}
	echo json_encode($res);
});

$app->get('/api/user/verify/{vkey}', function(Request $req, Response $res) {
	$userModel = new User();
	$vkey = $req->getAttribute('vkey');
	$row = $userModel->isVerified($vkey);
	$res = ['ok' => true];
	if ($row) {
		if (!$userModel->verifyUser($vkey)) {
			$res['ok'] = false;
			if ($row->verified == 1)
				$res['err'] = 'Already verified';
			else
				$res['err'] = 'Cant verify';
		}
	} else {
		$res['ok'] = false;
		$res['err'] = 'User not found';
	}
	echo json_encode($res);
});

$app->post('/api/user/update/{id}', function(Request $req, Response $res) {
	$userModel = new User();
	$data = [
		'id' => $req->getAttribute('id'),
		'first_name' => $req->getParam('first_name'),
		'last_name' => $req->getParam('last_name'),
		'username' => $req->getParam('username'),
		'email' => $req->getParam('email'),
		'gender' => $req->getParam('gender'),
		'looking' => $req->getParam('looking'),
		'biography' => $req->getParam('biography'),
		'tags' => $req->getParam('tags'),
		'address' => $req->getParam('address'),
		'city' => $req->getParam('city'),
		'country' => $req->getParam('country'),
		'postal_code' => $req->getParam('postal_code'),
		'phone' => $req->getParam('phone')
	];
	$res = [
		'response' => $data,
		'err' => '',
		'ok' => true
	];
	if ($userModel->isUser($data['id'])) {
		if (!$userModel->updateUser($data)) {
			$res['ok'] = false;
			$res['err'] = 'Cant update';
		}
	} else {
		$res['ok'] = false;
		$res['err'] = 'User not found';
	}
	echo json_encode($res);
});

$app->post('/api/user/delete/{id}', function(Request $req, Response $res) {
	$userModel = new User();
	$id = $req->getAttribute('id');
	if ($userModel->isUser($id)) {
		if (!$userModel->deleteUser($id)) {
			$res['ok'] = false;
			$res['err'] = 'Cant delete';
		}
	} else {
		$res['ok'] = false;
		$res['err'] = 'User not found';
	}
	echo json_encode($res);
});
