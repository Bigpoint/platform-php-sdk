PHP - SDK
=========

This PHP - SDK helps developer to use the platform 2.0

Example
-------

<?php

$config = array(
    'client_id' => 'CLIENTID',
    'client_secret' => 'CLIENTSECRET',
);

$factory = new Bigpoint\Factory();

$api = $factroy->createApi($config);

$api->call('/me');
