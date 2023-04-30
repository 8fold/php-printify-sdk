<?php
declare(strict_types=1);

namespace Eightfold\Printify;

use Eightfold\Printify\Shops\Shop;

use Eightfold\Printify\Shops\Products\Product;

/**
 * Supported endpoints.
 */
class Endpoints
{
    public static function getShops(): string
    {
        return '/shops.json';
    }

    public static function getProducts(
        int|Shop $shop,
        int $page = 1,
        int $limit = 10
    ): string {
        if (is_int($shop) === false) {
            $shop = $shop->id();
        }

        if ($page === 1 and $limit === 10) {
            return '/shops/' . $shop . '/products.json';
        }
        return '/shops/' . $shop . '/products.json?page=' . $page .
            '&limit=' . $limit;
    }

    public static function getProduct(int|Shop $shop, string $productId): string
    {
        if (is_int($shop) === false) {
            $shop = $shop->id();
        }
        return '/shops/' . $shop . '/products/' . $productId . '.json';
    }

    public static function postPublishingSucceeded(Product $product): string
    {
        $id = $product->id();
        $shopId = $product->shopId();
        return '/shops/' . $shopId . '/products/' . $id . '/publishing_succeeded.json';
    }
}
