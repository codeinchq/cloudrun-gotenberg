# GCP Cloud Run Gotenberg for PHP 

The PHP 8.2+ library provides an authenticated Gotenberg client using [`codeinc/cloudrun-auth-http-client`](https://packagist.org/packages/codeinc/cloudrun-auth-http-client) to be used with a [Gotenberg](https://gotenberg.dev/) service running on [Google Cloud Platform Cloud Run](https://cloud.google.com/run?hl=en).

## Installation

The library is available on [Packagist](https://packagist.org/packages/codeinc/cloudrun-gotenberg). You can install it
using [Composer](https://getcomposer.org):

```shell
composer require codeinc/cloudrun-gotenberg
```

## Usage

This library is modeled after the [official Gotenberg PHP client](https://packagist.org/packages/gotenberg/gotenberg-php). The methods of the class `CodeInc\CloudRunGotenberg\CloudRunGotenberg` are the same as the `Gotenberg\Gotenberg` class (but they are not `static`). 

The requests are authenticated using [`codeinc/cloudrun-auth-http-client`](https://packagist.org/packages/codeinc/cloudrun-auth-http-client). A service account is required to authenticate the requests. Check [this page](https://github.com/codeinchq/cloudrun-auth-http-client?tab=readme-ov-file#usage) to learn how to create and authorized a service account and obtain the service account key.

_The following conversion examples are extracted from [Gotenberg PHP client documentation](https://github.com/gotenberg/gotenberg-php?tab=readme-ov-file#quick-examples)._

```php
use CodeInc\CloudRunGotenberg\CloudRunGotenberg;
use Gotenberg\Stream;

// Creates the Cloud Run Gotenberg client 
$cloudRunGotenberg = new CloudRunGotenberg(
    // Cloud Run service URL
    'https://my-service-12345-uc.a.run.app',
    // path to your service account key or array of credentials 
    '/path/to/your/service-account-key.json' 
);

// Converts a target URL to PDF and saves it to a given directory.
$filename = $cloudRunGotenberg->save(
    $cloudRunGotenberg->chromium()->pdf()->url('https://my.url'), 
    $pathToSavingDirectory
);

// Converts Office documents to PDF and merges them.
$response = $cloudRunGotenberg->send(
    $cloudRunGotenberg->libreOffice()
        ->merge()
        ->convert(
            Stream::path($pathToDocx),
            Stream::path($pathToXlsx)
        )
);
```

## License

The library is published under the MIT license (see [`LICENSE`](LICENSE) file).