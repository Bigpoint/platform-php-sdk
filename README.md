PHP - SDK
=========

This PHP - SDK helps developer to use an Oauth2 secured platform.

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

Travis CI
---------

The cookbook includes a configuration for [Travis CI](https://travis-ci.org) that
will run phpunit each time changes are pushed to GitHub. Simply enable Travis
for your GitHub repository to get free continuous integration.

[![Build Status](https://api.travis-ci.org/Bigpoint/platform-php-sdk.png)](https://travis-ci.org/Bigpoint/platform-php-sdk)
