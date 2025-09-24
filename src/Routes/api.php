<?php

use Src\Controllers\TodoController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// normalize trailing slash
$path = rtrim($uri, '/');

$basePaths = [
    '/credit_debit/public',
    '/credit_debit/public/index.php',
];

// GET index
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    foreach ($basePaths as $bp) {
        if ($path === $bp) {
            (new TodoController())->index();
            exit;
        }
    }

    http_response_code(404);
    echo json_encode([
        "error" => "Route not found",
        "requested_uri" => $_SERVER['REQUEST_URI'],
        "parsed_path" => $uri
    ]);
    exit;
}

// POST store
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($basePaths as $bp) {
        if ($path === $bp . '/store') {
            (new TodoController())->store();
            exit;
        }
    }

    http_response_code(404);
    echo json_encode([
        "error" => "Route not found",
        "requested_uri" => $_SERVER['REQUEST_URI'],
        "parsed_path" => $uri
    ]);
    exit;
}

// other methods not allowed
http_response_code(405);
echo json_encode(["error" => "Method not allowed"]);
exit;
