> Note: Delete the labels in the new repo and use https://github.com/jvandemo/copy-github-labels-cli to copy the ones found here to the new repo

# 8fold Printify SDK for PHP

{brief description}


## Installation

{how does one install the product}

## Usage

To create a connection:

```
use Eightfold\Printify\Printify;

$printify = Printify::init({'YOUR_ACCESS_TOKEN'});
```

We want to minimize the number API calls made; therefore, the recommended starting point to receive a list of products and variations in a single call is as follows:

```
use Eightfold\Printify\Printify;

$products = Printify::init({'YOUR_ACCESS_TOKEN'})->getProductsIn({'THE_SHOP_ID'});
```

To get a single product in a single call:

use Eightfold\Printify\Printify;```

$product = Printify::init({'YOUR_ACCESS_TOKEN'})
    ->getProductWithIn({'THE_PRODUCT_ID'}, {'THE_SHOP_ID'});
```

## Details

Methods starting with `get` perform API requests; specifically, a `GET` request.

## Other

{links or descriptions or license, versioning, and governance}
