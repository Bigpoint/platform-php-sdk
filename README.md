PHP - SDK
=========

This PHP - SDK helps developer to use the platform 2.0

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
    $$response = $api->call('/me');
    echo $response->getContent();
} catch (Exception $e) {
    echo $e->getMessage();
}

```

The URI at which a request for an authorization will be serviced

```
<?php
// ...
$api->getAuthorizationRequestUri();
```
