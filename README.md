PHP - SDK
=========

This PHP - SDK helps developer to use an Oauth2 secured platform.

[![Build Status](https://api.travis-ci.org/Bigpoint/platform-php-sdk.png)](https://travis-ci.org/Bigpoint/platform-php-sdk)
[![Coverage Status](https://coveralls.io/repos/Bigpoint/platform-php-sdk/badge.png)](https://coveralls.io/r/Bigpoint/platform-php-sdk)
[![Dependency Status](https://www.versioneye.com/user/projects/5225fbae632bac657f000663/badge.png)](https://www.versioneye.com/user/projects/5225fbae632bac657f000663)

Example
-------

```php
<?php
require 'vendor/autoload.php';

$config = array(
    'client_id'     => 'CLIENTID',
    'client_secret' => 'CLIENTSECRET',
    'grant_type'    => 'authorization_code',
    //'grant_type'    => 'client_credentials',
    'redirect_uri'  => 'http://localhost', // optional, otherwise the current URI will used
);

$factory  = new Bigpoint\Factory();
$api      = $factory->createApi($config);
try {
    $user_id = $api->getUser();
    if (null !== $user_id) {
        $response = $api->call('/me');
        echo $response->getContent();
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

```

The URI at which a request for an authorization will be serviced.

```
<?php
// ...
$api->getAuthorizationRequestUri();
```

Tests
-----

The tests can be executed by using the phpunit command line tool from the base directory.

```
phpunit
```

The coverage report will generated to base directory/coverage.

The Xdebug extension is required otherwise no code coverage will be generated.
