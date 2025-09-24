<?php

namespace Src\Controllers;

use Src\Config\Database;
use Src\Models\Todo;
use Src\Helpers\Response;

class TodoController
{
    public function index()
    {
        $db = (new Database())->connect();
        $todo = new Todo($db);

        $todos = $todo->all();
        Response::json($todos);
    }

    public function store()
    {
        // Accept JSON body or form-encoded data
        $raw = file_get_contents('php://input');
        $input = json_decode($raw, true);

        // Fallback to $_POST when form-encoded
        $name = null;
        $status = null;

        if (is_array($input)) {
            $name = isset($input['name']) ? trim($input['name']) : null;
            $status = isset($input['status']) ? trim($input['status']) : null;
        } else {
            $name = isset($_POST['name']) ? trim($_POST['name']) : null;
            $status = isset($_POST['status']) ? trim($_POST['status']) : null;
        }

        // Basic validation
        if (empty($name)) {
            Response::json(['error' => 'The `name` field is required.'], 400);
        }

        $db = (new Database())->connect();
        $todo = new Todo($db);

        $insertId = $todo->create($name, $status);

        if ($insertId === false) {
            Response::json(['error' => 'Failed to create todo.'], 500);
        }

        http_response_code(201);
        Response::json([
            'message' => 'Todo created',
            'id' => $insertId,
            'name' => $name,
            'status' => $status
        ], 201);
    }
}
