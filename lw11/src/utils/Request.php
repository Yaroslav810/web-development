<?php


/**
 * Class for working with request parameters
 */

class Request
{
    public static function getGETParameter(string $key): ?string
    {
        return $_GET[$key] ?? null;
    }

    public static function getPOSTParameter(string $key): ?string
    {
        return $_POST[$key] ?? null;
    }

    public static function getRequestMethod(): ?string
    {
        return $_SERVER['REQUEST_METHOD'] ?? null;
    }
}