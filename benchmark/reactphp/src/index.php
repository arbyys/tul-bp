<?php

use Psr\Http\Message\ServerRequestInterface;
use React\Http\HttpServer;
use React\Http\Message\Response;
use React\Socket\SocketServer;

require __DIR__ . "/vendor/autoload.php";

$http = new HttpServer(function (ServerRequestInterface $request) {
	return Response::json([
		'version' => phpversion(),
		'name' => 'PHP (ReactPHP)',
		'timestamp' => time(),
	]);
});

$socket = new React\Socket\SocketServer('0.0.0.0:8005');
$http->listen($socket);

echo "React PHP server is started at http://127.0.0.1:8005\n";