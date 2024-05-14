<?php

use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http\Request;
use Workerman\Protocols\Http\Response;
use Workerman\Worker;

require_once __DIR__ . '/vendor/autoload.php';

$worker = new Worker('http://0.0.0.0:8012');

$worker->count = 4;

$worker->onMessage = function (TcpConnection $connection, Request $request) {
	echo "Request received {$request->uri()}" . PHP_EOL;

	$connection->send(
		new Response(
			200,
			['Content-type' => 'application/json'],
			json_encode([
                'version' => phpversion(), 
                'name' => 'PHP (Workerman)',
                'timestamp' => time(),
            ])
		)
	);
};

echo "Listening on {$worker->getSocketName()}" . PHP_EOL;
Worker::runAll();