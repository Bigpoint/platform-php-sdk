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
