# Code Inc. PDF converter PHP client

The library provides a `GotenbergClient` class that allows you to convert office files to PDF. It uses Code Inc.'s Cloud Run authentication library to authenticated the requests sent to a Cloud Run service  

## Installation

The library is available on [Packagist](https://packagist.org/packages/codeinc/cloudrun-gotenberg). You can install it
using [Composer](https://getcomposer.org):

```shell
composer require codeinc/cloudrun-gotenberg
```

## Usage

The library provides a `GotenbergClient` class that allows you to convert office files to PDF using the Code Inc. PDF converter service. 

```php
use CodeInc\CloudRunGotenberg\CloudRunGotenberg;
use Gotenberg\Gotenberg;
use Gotenberg\Stream;

// Creates the Cloud Run Gotenberg client 
$gotenberg = CloudRunGotenberg::fromUrlAndJsonKey(
    // Cloud Run service URL
    'https://my-service-12345-uc.a.run.app',
    // path to your service account key or array of credentials 
    '/path/to/your/service-account-key.json' 
)

// The following examples are extracted from Gotenberg PHP client documentation
// https://packagist.org/packages/gotenberg/gotenberg-php

// Converts a target URL to PDF and saves it to a given directory.
$filename = $gotenberg->save(
    Gotenberg::chromium($apiUrl)->pdf()->url('https://my.url'), 
    $pathToSavingDirectory
);

// Converts Office documents to PDF and merges them.
$response = $gotenberg->send(
    Gotenberg::libreOffice($apiUrl)
        ->merge()
        ->convert(
            Stream::path($pathToDocx),
            Stream::path($pathToXlsx)
        )
);
```

## License

The library is published under the MIT license (see [`LICENSE`](LICENSE) file).