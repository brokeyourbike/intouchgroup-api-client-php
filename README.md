# intouchgroup-api-client

[![Latest Stable Version](https://img.shields.io/github/v/release/brokeyourbike/intouchgroup-api-client-php)](https://github.com/brokeyourbike/intouchgroup-api-client-php/releases)
[![Total Downloads](https://poser.pugx.org/brokeyourbike/intouchgroup-api-client/downloads)](https://packagist.org/packages/brokeyourbike/intouchgroup-api-client)

IntouchGroup API Client for PHP

## Installation

```bash
composer require brokeyourbike/intouchgroup-api-client
```

## Usage

```php
use BrokeYourBike\IntouchGroup\Client;
use BrokeYourBike\IntouchGroup\Interfaces\ConfigInterface;

assert($config instanceof ConfigInterface);
assert($httpClient instanceof \GuzzleHttp\ClientInterface);

$apiClient = new Client($config, $httpClient);
```

## Authors
- [Ivan Stasiuk](https://github.com/brokeyourbike) | [Twitter](https://twitter.com/brokeyourbike) | [LinkedIn](https://www.linkedin.com/in/brokeyourbike) | [stasi.uk](https://stasi.uk)

## License
[BSD-3-Clause License](https://github.com/brokeyourbike/intouchgroup-api-client-php/blob/main/LICENSE)
