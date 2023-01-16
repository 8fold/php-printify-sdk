<?php
declare(strict_types=1);

namespace Eightfold\Printify;

use InvalideArgumentException;

use Eightfold\Printify\Printify;

// use Psr\Http\Message\ResponseInterface;
//
// use Nyholm\Psr7\Request;
use Nyholm\Psr7\Factory\Psr17Factory;
//
use Buzz\Client\FileGetContents as HttpClient;
//
// use Eightfold\Printify\Shops\Shops; // List of shops associated with account.
// use Eightfold\Printify\Shops\Shop; // Individual shop associated with account.
//
// use Eightfold\Printify\Shops\Products\Products; // List of products within a Shop.
// use Eightfold\Printify\Shops\Products\Product; // Individual product within Shop.

class PrintifyClient
{
    private const DEFAULT_API_BASE = 'https://api.printify.com/v1';

    /**
     * Static initializer for client used to send requests to Printify's API.
     *
     * @param array|string $config If array, MUST have key accessToken.
     *        If string, MUST be the accessToken for the custom integration.
     *
     * @return PrintifyClient Instance of the PrintifyClient.
     */
    public static function connect(array|string $config): self
    {
        if (is_string($config)) {
            $config = [
                'accessToken' => $config
            ];

        } elseif (is_array($config) === false) {
            throw new InvalidArgumntException('$config MUST be string or array');

        }

        $config = array_merge(self::defaultConfig(), $config);
        self::validateConfig($config);

        return new self($config);
    }

    private static function defaultConfig(): array
    {
        return [
            'accessToken' => false,
            'apiBase'     => self::DEFAULT_API_BASE
        ];
    }

    private static function validateConfig(array $config): void
    {
        if (array_key_exists('accessToken', $config) === false) {
            throw new InvalidArgumentException('Missing accessToken for config.');
        }

        if (is_string($config['accessToken']) === false) {
            throw new InvalidArgumentException('accessToken MUST be a string');
        }

        if ($config['accessToken'] === '') {
            throw new InvalidArgumentException('accessToken MUST NOT be an empty string.');
        }

        if (preg_match('/\s/', $config['accessToken'])) {
            throw new InvalidArgumentException('accessToken MUST NOT contain whitespace.');
        }

        if (array_key_exists('apiBase', $config) === false) {
            throw new InvalidArgumentException('Missing apiBase for config.');
        }
    }

    final private function __construct(private array|string $config)
    {
        Printify::setAccessToken($this->config['accessToken']);
    }
//     /** @var string The access token for the custom integration. */
//     private static $accessToken;
//
//     public static function setAccessToken(string $accessToken): void
//     {
//         self::$accessToken = $accessToken;
//     }

//
//     private const METHOD_GET = 'GET';
//
//     private const BASE_URL = 'https://api.printify.com/v1';
//
//     private static string $accessToken;
//
//     private static Psr17Factory $factory;
//
    // private static HttpClient $client;
//
//     public static function init(string $accessToken): self
//     {
//         self::$accessToken = $accessToken;
//
//         return new self();
//     }
//
    // private static function factory(): Psr17Factory
    // {
    //     if (isset(self::$factory) === false) {
    //         self::$factory = new Psr17Factory();
    //     }
    //     return self::$factory;
    // }
//
    // private static function client(): HttpClient
    // {
    //     if (isset(self::$client) === false) {
    //         self::$client = new HttpClient(self::factory());
    //     }
    //     return self::$client;
    // }
//
//     public static function authorizationHeader(): array
//     {
        // return ['Authorization' => 'Bearer ' . self::$accessToken];
//     }
//
//     public static function get(string $endpoint)
//     {
//         return self::responseFor($endpoint, self::METHOD_GET);
//     }
//
//     private static function responseFor(
//         string $endpoint,
//         string $method
//     ): ResponseInterface {
        // return self::client()->sendRequest(
        //     new Request(
        //         $method,
        //         self::BASE_URL . $endpoint,
        //         self::authorizationHeader()
        //     )
        // );
//     }
//
//     final private function __construct()
//     {
//     }
//
//     public function getShops(): Shops
//     {
//         return Shops::init();
//     }
//
//     public function getShopWithId(int $id): Shop
//     {
//         return $this->getShops()->shopWithId($id);
//     }
//
//     public function getProductsIn(int $shopId): Products
//     {
//         return Products::get($shopId);
//     }
//
//     public function getProductWithIn(string $productId, int $shopId): Product
//     {
//         return Product::get($productId, $shopId);
//     }
}
