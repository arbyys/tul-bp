<?php

use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;

$http = new Server("0.0.0.0", 8007);

$http->on("start", function ($server) {
    echo "Swoole HTTP server is started at http://127.0.0.1:8007\n";
});

$http->on("request", function (Request $request, Response $response) {
    $response->header("Content-Type", "application/json");    
	$response->end(json_encode([
        'version' => phpversion(), 
		'name' => 'PHP (Swoole)',
		'timestamp' => time(),
	]));
});

$http->start();