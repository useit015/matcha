<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../vendor/autoload.php';
require_once '../app/config/config.php';
require_once '../app/helpers/database.php';
require_once '../app/helpers/validate.php';

$app = new \Slim\App;

require_once '../app/routes/users.php';

$app->run();
