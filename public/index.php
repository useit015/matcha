<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/database.php';
require '../src/helpers/validate.php';

$app = new \Slim\App(['settings' => [
	'displayErrorDetails' => true,
	'error_reporting' => true
	]
]);

require '../src/routes/customers.php';

$app->run();
