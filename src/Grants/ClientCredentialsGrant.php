<?php

namespace League\OAuth2\Server\Grants;

use League\OAuth2\Server\Grants\Routes\ClientCredentialsRoute;
use League\OAuth2\Server\Grants\Routes\RouteInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Request;

class ClientCredentialsGrant implements GrantInterface
{
    /**
     * @inheritdoc
     */
    public function getRoutes()
    {
        return [
            new ClientCredentialsRoute()
        ];
    }

    /**
     * @inheritdoc
     */
    public function executeRoute(RouteInterface $route, ServerRequestInterface $request)
    {
        switch ($route) {
            case ($route instanceof ClientCredentialsRoute):
                return $this->parseClientCredentialsRoute($request);
                break;
        }

        throw new \LogicException('This grant cannot execute route ' . get_class($route));
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     */
    protected function parseClientCredentialsRoute(ServerRequestInterface $request)
    {

    }
}
