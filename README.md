> Note: Delete the labels in the new repo and use https://github.com/jvandemo/copy-github-labels-cli to copy the ones found here to the new repo

# 8fold Printify SDK for PHP

{brief description}

## Installation

{how does one install the product}

## Usage

### Initialize Client

```php
use Eightfold\Printify\Client;
use Eightfold\Printify\Printify;

$client = Client::connect(
  Printify::account({'your Printify access token'})
);
```

### Use Client

The Client is the recommended entry point and leverages a fluent approach.

**Retrieve a list of shops in a Printify account**

```php
// API call
$client->getShops();
```

*Retrieve a single shop (from the list of shops)*

```php
// API call
$client->getShop({shop id});
```

*Retrieve a Shop instance (supports lazy loading)*

```php
// No API call
$shop = $client->shop({shop id});

$shop->id();

// API call
$shop->title();
```

**Retrieve a list of products in a Shop**

```php
// API call
$client->getProducts($shop);
```

*Retrieve a single Product*

```php
// API call
$client->getProduct({product id});
```

*Retrieve a Product instance (supports lazy loading)*

```php
// No API call
$product = $client->getProduct($shop, {product id});

// No API call
$product->id();

$product->shopId();

// API call
$product->title();

$product->description();

// and other properties
```

*Retrieve a collection of Variants for a Product*

```php
// API call
$variants = $product->variants();
```

*Retrieve a single Variant from a Product*

```php
// API call
$variant = $product->variants()->atIndex(0);

$variant = $product->variants()->variantWithId({variant id});
```

*Retrieve a collection of Images for a Product*

```php
$images = $product->images();
```

*Retrieve Images for a Variant*

```php
$images = $variant->images($product);

$images = $product->imagesForVariant($variant);
```


**Set Product publish status to succeeded**

```php
$client->postPublishingSucceededForProduct($product);
```

## Details

The project's folder structure is designed to mirror the Printify API endpoint structures.

We delay API calls until the last responsible moment. We afford you the opportunity to do the same.

Methods starting with `get` perform API requests, specifically, a `GET` request.

Methods starting with `post` perform API requests, specifically, a `POST` request.

Methods starting with `delete` perform API requests, specifically, a `DELETE` request.

Methods starting with `put` perform API requests, specifically, a `PUT` request.

## Other

{links or descriptions or license, versioning, and governance}
