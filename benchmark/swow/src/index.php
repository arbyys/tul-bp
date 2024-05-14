<?php

use Swow\Coroutine;
use Swow\CoroutineException;
use Swow\Errno;
use Swow\Http\Protocol\ProtocolException;
use Swow\Psr7\Message\Response;
use Swow\Psr7\Psr7;
use Swow\Psr7\Server\Server;
use function Swow\Sync\waitAll;

require_once __DIR__ . '/vendor/autoload.php';

$server = new Server();
$server->bind('0.0.0.0', 8011);
$server->listen();

echo "Swow http server is started at http://0.0.0.0:8011\n";

Coroutine::run(function () use ($server) {
	while (true) {
        $connection = $server->acceptConnection();
        Coroutine::run(function () use ($connection) {
            try {
                while (true) {
                    $request = null;
                    try {
                        $request = $connection->recvHttpRequest();
                        echo "Request received {$request->getUri()}" . PHP_EOL;

                        $response = new Response();
                        $response->setStatus(200);
                        $response->setHeader('Content-type', 'application/json');
                        $response->getBody()->write(json_encode([
                            'version' => phpversion(),
                            'name' => 'PHP (Swow)',
                            'timestamp' => time(),
                        ]));

                        $connection->sendHttpResponse($response);
                    } catch (ProtocolException $exception) {
                        $connection->error($exception->getCode(), $exception->getMessage());
                    }
                    if (!$request || !Psr7::detectShouldKeepAlive($request)) {
                        break;
                    }
                }
            } catch (Throwable $exception) {
                echo $exception->getMessage() . PHP_EOL;
            } finally {
                $connection->close();
            }
        });
	}
});
waitAll();