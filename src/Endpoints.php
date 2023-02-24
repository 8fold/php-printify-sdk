<?php
declare(strict_types=1);

namespace Eightfold\Printify;

use Eightfold\Printify\Shops\Shop;

/**
 * Supported endpoints.
 */
class Endpoints
{
    public static function getShops(): string
    {
        return '/shops.json';
    }

    public static function getProducts(int|Shop $shop): string
    {
        if (is_a($shop, Shop::class)) {
            $shop = $shop->id();
        }
        return '/shops/' . $shop . '/products.json';
    }

    public static function getProduct(int|Shop $shop, string $productId): string
    {
        if (is_a($shop, Shop::class)) {
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
