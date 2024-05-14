<?php
header('Content-type: application/json');

echo json_encode([
    'version' => phpversion(),
    'name' => 'PHP (FrankenPHP)',
    'timestamp' => time(),
]);
