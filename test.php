<?php

use League\OAuth2\Server\Grants\ClientCredentialsGrant;
use League\OAuth2\Server\Server;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\Request;

include('vendor/autoload.php');

$request = Request::create('http://localhost/access_token', 'GET', ['foo' => 'bar', 'a' => 'b']);
$psr7request = (new DiactorosFactory())->createRequest($request);

$server = new Server();
$server->enableGrant(new ClientCredentialsGrant());
$server->run($psr7request);
