<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the correct path to vendor autoload
$autoloadPath = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
} else {
    die("Autoloader not found at: " . $autoloadPath);
}

// Manually require files with error checking
$requiredFiles = [
    __DIR__ . '/../src/Config/config.php',
    __DIR__ . '/../src/Models/Todo.php',
    __DIR__ . '/../src/Helpers/Response.php',
    __DIR__ . '/../src/Controllers/TodoController.php',
    __DIR__ . '/../src/Routes/api.php'
];

foreach ($requiredFiles as $file) {
    if (file_exists($file)) {
        require_once $file;
        // echo "<!-- Loaded: " . basename($file) . " -->\n";
    } else {
        echo "<!-- Warning: File not found: " . $file . " -->\n";
    }
}
