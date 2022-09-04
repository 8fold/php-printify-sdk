<?php
declare(strict_types=1);

namespace Eightfold\Printify;

use Psr\Http\Message\ResponseInterface;

use Nyholm\Psr7\Request;
use Nyholm\Psr7\Factory\Psr17Factory;

use Buzz\Client\FileGetContents as HttpClient;

use Eightfold\Printify\Shops\Shops; // List of shops associated with account.
use Eightfold\Printify\Shops\Shop; // Individual shop associated with account.

use Eightfold\Printify\Shops\Products\Products; // List of products within a Shop.
use Eightfold\Printify\Shops\Products\Product; // Individual product within Shop.

class Printify
{
    private const METHOD_GET = 'GET';

    private const BASE_URL = 'https://api.printify.com/v1';

    private static string $accessToken;

    private static Psr17Factory $factory;

    private static HttpClient $client;

    public static function init(string $accessToken): self
    {
        self::$accessToken = $accessToken;

        return new self();
    }

    private static function factory(): Psr17Factory
    {
        if (isset(self::$factory) === false) {
            self::$factory = new Psr17Factory();
        }
        return self::$factory;
    }

    private static function client(): HttpClient
    {
        if (isset(self::$client) === false) {
            self::$client = new HttpClient(self::factory());
        }
        return self::$client;
    }

    public static function authorizationHeader(): array
    {
        return ['Authorization' => 'Bearer ' . self::$accessToken];
    }

    public static function get(string $endpoint)
    {
        return self::responseFor($endpoint, self::METHOD_GET);
    }

    private static function responseFor(
        string $endpoint,
        string $method
    ): ResponseInterface {
        return self::client()->sendRequest(
            new Request(
                $method,
                self::BASE_URL . $endpoint,
                self::authorizationHeader()
            )
        );
    }

    final private function __construct()
    {
    }

    public function getShops(): Shops
    {
        return Shops::init();
    }

    public function getShopWithId(int $id): Shop
    {
        return $this->getShops()->shopWithId($id);
    }

    public function getProductsIn(int $shopId): Products
    {
        return Products::get($shopId);
    }

    public function getProductWithIn(string $productId, int $shopId): Product
    {
        return Product::get($productId, $shopId);
    }
}
