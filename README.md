<img src="https://bitpay.com/_nuxt/img/bitpay-logo-blue.1c0494b.svg" width="150">

# BitPay PHP Client
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://raw.githubusercontent.com/bitpay/php-bitpay-client-v2/master/LICENSE)
[![Packagist](https://img.shields.io/packagist/v/bitpay/sdk.svg?style=flat-square)](https://packagist.org/packages/bitpay/sdk)
[![Total Downloads](https://poser.pugx.org/bitpay/sdk/downloads.svg)](https://packagist.org/packages/bitpay/sdk)
[![Latest Unstable Version](https://poser.pugx.org/bitpay/sdk/v/unstable.svg)](https://packagist.org/packages/bitpay/sdk)

Full implementation of the BitPay Payment Gateway. This library implements BitPay's [Cryptographically Secure RESTful API](https://bitpay.com/api).

Our Lite version will most likely be all you need to integrate to your site, available [here](https://github.com/bitpay/php-bitpay-light-client)

## Getting Started

To get up and running with our PHP library quickly, follow [the guide](https://bitpay.readme.io/reference/php-full-sdk-getting-started)

## Support

* https://github.com/bitpay/php-bitpay-client-v2/issues
* https://support.bitpay.com

### Requirements

- PHP version: 8.0 / 8.1 / 8.2
- PHP extensions: json, reflection

## Unit Tests
```php
./vendor/bin/phpunit --testsuite "Unit"
```

## Functional Tests

To run functional tests you will need to perform the following steps.

### Generate Configuration


Run the following command to generate `BitPay.config.yml`:

```bash
composer setup
```

Copy `BitPay.config.yml` to the `test/functional/BitPaySDK` directory.

Copy `PrivateKeyName.key` to the `setup` directory.

### Create Recipient

To submit requests you should:

1. Create a recipient in https://test.bitpay.com/dashboard/payouts/recipients
2. Accept the invite in the recipient's email inbox
3. Create a file at `test/functional/BitPaySDK/email.txt` containing the email
   address of the recipient you created in step 1.

### Run the Functional Tests

Run the following command to execute the functional tests:

```php
./vendor/bin/phpunit --testsuite "Functional"
```

## Contribute

To contribute to this project, please fork and submit a pull request.

## License

MIT License

Copyright (c) 2019 BitPay

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
