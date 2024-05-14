<?php


use OpenSwoole\Http\Server;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;
use OpenSwoole\Util;

$http = new Server("0.0.0.0", 8001);

$http->on("start", function ($server) {
    echo "Swoole HTTP server is started at http://127.0.0.1:8001\n";
});

$http->on("request", function (Request $request, Response $response) {
    $response->header("Content-Type", "application/json");    
	$response->end(json_encode([
        'version' => phpversion(), 
		'name' => 'PHP (OpenSwoole)',
		'timestamp' => time(),
	]));
});

$http->start();