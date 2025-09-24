<?php

namespace Src\Helpers;

class Response
{
    private static function send($data, $status, $contentType = "application/json")
    {
        http_response_code($status);
        header("Content-Type: $contentType");

        if ($contentType === "application/json") {
            echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            echo $data;
        }
        exit;
    }

    // Generic JSON
    public static function json($data, $status = 200)
    {
        self::send($data, $status, "application/json");
    }

    // Success response
    public static function success($message = "OK", $data = [], $status = 200)
    {
        self::json([
            "status" => "success",
            "message" => $message,
            "data" => $data
        ], $status);
    }

    // Error response
    public static function error($message = "Something went wrong", $status = 500)
    {
        self::json([
            "status" => "error",
            "message" => $message
        ], $status);
    }

    // Not Found
    public static function notFound($message = "Resource not found")
    {
        self::error($message, 404);
    }

    // Unauthorized
    public static function unauthorized($message = "Unauthorized")
    {
        self::error($message, 401);
    }

    // Forbidden
    public static function forbidden($message = "Forbidden")
    {
        self::error($message, 403);
    }

    // No Content (204)
    public static function noContent()
    {
        http_response_code(204);
        exit;
    }
}
