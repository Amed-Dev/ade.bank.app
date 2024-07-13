<?php
require_once __DIR__ . '/index.php';

use App\Controllers\ApiController;

$controller = new ApiController();
$controller->handleRequest();
