<?php

namespace App;

class ResponseHelper
{
    public static function success($data = [], $message = 'Success', $statusCode = 200)
    {
        return response()->json(['message' => $message, 'data' => $data], $statusCode);
    }

    public static function notFound($message = 'Not Found', $statusCode = 404)
    {
        return response()->json(['message' => $message], $statusCode);
    }

    public static function error($message = 'Error', $statusCode = 400)
    {
        return response()->json(['message' => $message], $statusCode);
    }

    public static function errors($fields = [], $message = 'Validation Error', $statusCode = 422)
    {
        return response()->json(['message' => $message, "errors" => $fields], $statusCode);
    }
}
