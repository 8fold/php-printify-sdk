<?php
declare(strict_types=1);

namespace Eightfold\Printify;

class Printify
{
    /** @var string The access token for the custom integration. */
    private static string $accessToken;

    /** @var string The base URL for the Printify API. */
    private static string $apiBase;

    public static function createSingleton(array $config): void
    {
        self::setAccessToken($config['accessToken']);
        self::setApiBase($config['apiBase']);
    }

    public static function setAccessToken(string $accessToken): void
    {
        self::$accessToken = $accessToken;
    }

    public static function accessToken(): string
    {
        return self::$accessToken;
    }

    public static function setApiBase(string $apiBase): void
    {
        self::$apiBase = $apiBase;
    }

    public static function apiBase(): string
    {
        return self::$apiBase;
    }
}
