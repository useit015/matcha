<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->get('/api/customers', function(Request $req, Response $res) {
	$db = new Database();
	$db->query('SELECT * FROM customers');
	echo json_encode($db->resultSet());
});

$app->get('/api/customer/{id}', function(Request $req, Response $res) {
	$db = new Database();
	$db->query('SELECT * FROM customers WHERE id = :id');
	$db->bind(':id', $req->getAttribute('id'));
	echo json_encode($db->single());
});

$app->post('/api/customer/add', function(Request $req, Response $res) {
	$data = [
		'first_name' => $req->getParam('first_name'),
		'last_name' => $req->getParam('last_name'),
		'phone' => $req->getParam('phone'),
		'email' => $req->getParam('email'),
		'address' => $req->getParam('address'),
		'city' => $req->getParam('city'),
		'state' => $req->getParam('state'),
		'vkey' => bin2hex(random_bytes(10))
	];
	$val = new Validator();
	$err = [
		'first_name' => $val->validateName($data['first_name'], 'First'),
		'last_name' => $val->validateName($data['last_name'], 'Last'),
		'email' => $val->validateEmail($data['email'])
	];
	if (!empty($err['first_name']) || !empty($err['last_name']) || !empty($err['email']))
		die(json_encode(['response' => $err, 'errors' =>true]));
	$db = new Database();
	$db->query('INSERT INTO customers (first_name, last_name, phone, email, `address`, city, `state`, vkey) VALUES (:first_name, :last_name, :phone, :email, :address, :city, :state, :vkey)');
	if ($db->execute($data)) {
		mail($data['email'], 'Mail verification','http://localhost/slimPhp/public/api/customer/verify/'.$data['vkey']);
		echo json_encode(['response' => $data, 'errors' => false]);
	} else
		echo json_encode([]);
});

$app->get('/api/customer/verify/{vkey}', function(Request $req, Response $res) {
	$vkey = $req->getAttribute('vkey');
	$db = new Database();
	$db->query('SELECT verified FROM customers WHERE vkey = ?');
	$row = $db->single([$vkey]);
	if ($row) {
		if ($row->verified == 1)
			die('Already verified');
	} else
		die('Oups! Something went wrong.');
	$db->query('UPDATE customers SET verified = 1 WHERE vkey = ? AND verified = 0');
	if ($db->execute([$vkey]))
		echo 'done';
	else
		echo 'none';
});

$app->post('/api/customer/update/{id}', function(Request $req, Response $res) {
	$data = [
		'id' => $req->getAttribute('id'),
		'first_name' => $req->getParam('first_name'),
		'last_name' => $req->getParam('last_name'),
		'phone' => $req->getParam('phone'),
		'email' => $req->getParam('email'),
		'address' => $req->getParam('address'),
		'city' => $req->getParam('city'),
		'state' => $req->getParam('state')
	];
	$db = new Database();
	$db->query('SELECT * FROM customers WHERE id = ?');
	$db->execute([$data['id']]);
	if (!$db->rowCount())
		die(json_encode([]));
		$db->query('UPDATE customers SET first_name = :first_name, last_name = :last_name, phone = :phone, email = :email, `address` = :address, city = :city, `state` = :state WHERE id = :id');
	if ($db->execute($data))
		echo json_encode($data);
	else
		echo json_encode([]);
	});

$app->post('/api/customer/delete/{id}', function(Request $req, Response $res) {
	$id = $req->getAttribute('id');
	$db = new Database();
	$db->query('SELECT * FROM customers WHERE id = ?');
	$db->execute([$id]);
	if (!$db->rowCount())
		die(json_encode([]));
	$db->query('DELETE FROM customers WHERE id = ?');
	if ($db->execute([$id]))
		echo json_encode($id);
	else
		echo json_encode([]);
});
