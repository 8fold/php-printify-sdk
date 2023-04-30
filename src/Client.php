<?php
declare(strict_types=1);

namespace Eightfold\Printify;

use StdClass;

use Psr\Http\Message\ResponseInterface;

use Buzz\Client\FileGetContents as HttpClient;

use Nyholm\Psr7\Factory\Psr17Factory;

use Nyholm\Psr7\Request;

use Eightfold\Printify\Printify;
use Eightfold\Printify\Endpoints;

use Eightfold\Printify\Shops\Shops;
use Eightfold\Printify\Shops\Shop;

use Eightfold\Printify\Shops\Products\Products;
use Eightfold\Printify\Shops\Products\Product;

class Client
{
    private HttpClient $httpClient;

    public static function connect(Printify $account): self
    {
        return new self($account);
    }

    final private function __construct(private Printify $account)
    {
    }

    public function account(): Printify
    {
        return $this->account;
    }

    public function shop(int $withId): Shop
    {
        return Shop::withId($this, $withId);
    }

    /**
     * If a Shop with the specific ID is not found, the first Shop listed will
     * be returned.
     *
     * @param int $withId The Printify ID of the desired Shop.
     *
     * @return Shop|ResponseInterface If fails to get Shops, returns response.
     */
    public function getShop(int $withId): Shop|ResponseInterface|false
    {
        $shops = $this->getShops();
        if (is_a($shops, ResponseInterface::class)) {
            return $shops;
        }

        if (is_a($shops, Shops::class) === false) {
            return false;
        }

        $shop = $shops->shop(withId: $withId);
        if (is_a($shop, Shop::class) === false) {
            return false;
        }
        return $shop;
    }

    public function getShops(): Shops|ResponseInterface
    {
        $method   = 'GET';
        $endpoint = $this->account()->apiVersion() . Endpoints::getShops();

        $response = $this->httpClient()->sendRequest(
            new Request($method, $endpoint, $this->standardHeaders())
        );

        if ($this->responseIsNotOk($response)) {
            return $response;
        }
        return Shops::fromResponse($this, $response);
    }

    public function getProducts(
        int|Shop $shop,
        int $page = 1,
        int $limit = 10
    ): Products|ResponseInterface {
        $method   = 'GET';
        $endpoint = $this->account()->apiVersion() .
            Endpoints::getProducts($shop, $page, $limit);

        $response = $this->httpClient()->sendRequest(
            new Request($method, $endpoint, $this->standardHeaders())
        );

        if ($this->responseIsNotOk($response)) {
            return $response;
        }
        return Products::fromResponse($this, $response);
    }

    public function product(
        int|Shop $shop,
        string $productId
    ): Product {
        if (is_int($shop) === false) {
            $shop = $shop->id();
        }

        return Product::withId($this, $shop, $productId);
    }

    public function getProduct(
        int|Shop $shop,
        string $productId
    ): Product|ResponseInterface {
        $method   = 'GET';
        $endpoint = $this->account()->apiVersion() .
            Endpoints::getProduct($shop, $productId);

        $response = $this->httpClient()->sendRequest(
            new Request($method, $endpoint, $this->standardHeaders())
        );

        if ($this->responseIsNotOk($response)) {
            return $response;
        }
        return Product::fromResponse($this, $response);
    }

    public function postPublishingSucceededForProduct(
        Product $product,
        StdClass|null $external = null,
        bool $returnBool = false
    ): ResponseInterface|bool {
        $method   = 'POST';
        $endpoint = $this->account()->apiVersion() .
            Endpoints::postPublishingSucceeded($product);
        $headers  = $this->standardHeaders();

        $body = false;
        if ($external !== null) {
            $b = new StdClass();
            $b->external = json_encode($external);

            $body = json_encode($body);
        }

        $response = '';
        if ($body) {
            $response = $this->httpClient()->sendRequest(
                new Request($method, $endpoint, $headers, $body)
            );

        } else {
            $response = $this->httpClient()->sendRequest(
                new Request($method, $endpoint, $headers)
            );

        }

        if ($returnBool) {
            return $this->responseIsOk($response);
        }
        return $response;
    }

    private function responseIsNotOk(ResponseInterface $response): bool
    {
        return ! $this->responseIsOk($response);
    }

    private function responseIsOk(ResponseInterface $response): bool
    {
        $statusCode = $response->getStatusCode();
        return $statusCode > 199 and $statusCode < 300;
    }

    /**
     * @return array<string, string>
     */
    private function standardHeaders(): array
    {
        return [
            'Content-Type' => 'application/json;charset=utf-8',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->account()->accessToken()
        ];
    }

    private function httpClient(): HttpClient
    {
        if (isset($this->httpClient) === false) {
            $this->httpClient = new HttpClient(
                new Psr17Factory()
            );
        }
        return $this->httpClient;
    }
}
