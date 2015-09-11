<?php

namespace League\OAuth2\Server\Grants;

use League\OAuth2\Server\Grants\Routes\RouteInterface;
use Psr\Http\Message\ServerRequestInterface;

interface GrantInterface
{
    /**
     * @return RouteInterface[]
     */
    public function getRoutes();

    /**
     * @param \League\OAuth2\Server\Grants\Routes\RouteInterface $route
     * @param \Psr\Http\Message\ServerRequestInterface           $request
     *
     * @return
     */
    public function executeRoute(RouteInterface $route, ServerRequestInterface $request);
}
