<?php

use Nyholm\Psr7\Response;
use Nyholm\Psr7\Factory\Psr17Factory;

use Spiral\RoadRunner\Worker;
use Spiral\RoadRunner\Http\PSR7Worker;

require __DIR__ . "/vendor/autoload.php";

$worker = Worker::create();
$psrFactory = new Psr17Factory();
$psr7 = new PSR7Worker($worker, $psrFactory, $psrFactory, $psrFactory);

while ($req = $psr7->waitRequest()) {
    try {
		$response = new Response(
			200,
			['Content-type' => 'application/json'],
			json_encode([
                'version' => phpversion(),
                'name' => 'PHP (RoadRunner)',
                'timestamp' => time(),
			])
		);

        $psr7->respond($response);
    } catch (\Throwable $e) {
        $psr7->getWorker()->error((string)$e);
    }
}