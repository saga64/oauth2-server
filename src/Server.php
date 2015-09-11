<?php

namespace League\OAuth2\Server;

use League\Container\Container;
use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use League\OAuth2\Server\Grants\GrantInterface;
use League\OAuth2\Server\Grants\Routes\RouteInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\GrantRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\RepositoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class Server implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var GrantInterface[]
     */
    protected $enabledGrants = [];

    /**
     * @var RouteInterface[]
     */
    protected $routes = [];

    /**
     * @var array
     */
    protected $routeGrantMap = [];

    public function __construct()
    {
        $this->setContainer(new Container());
    }

    /**
     * @param \League\OAuth2\Server\Grants\GrantInterface $grant
     */
    public function enableGrant(GrantInterface $grant)
    {
        $this->getContainer()->add(get_class($grant), $grant, true);
        foreach ($grant->getRoutes() as $route) {
            $this->routes[] = $route;
            $this->routeGrantMap[get_class($route)] = get_class($grant);
        }
    }

    /**
     * Bind a repository to the server's DI container
     *
     * @param \League\OAuth2\Server\Repositories\RepositoryInterface $repository
     */
    public function addRepository(RepositoryInterface $repository)
    {
        switch ($repository) {
            case ($repository instanceof ClientRepositoryInterface):
                $this->getContainer()->singleton(ClientRepositoryInterface::class, $repository);
                break;
            case ($repository instanceof GrantRepositoryInterface):
                $this->getContainer()->singleton(GrantRepositoryInterface::class, $repository);
                break;
            case ($repository instanceof AuthCodeRepositoryInterface):
                $this->getContainer()->singleton(AuthCodeRepositoryInterface::class, $repository);
                break;
            case ($repository instanceof AccessTokenRepositoryInterface):
                $this->getContainer()->singleton(AccessTokenRepositoryInterface::class, $repository);
                break;
            case ($repository instanceof RefreshTokenRepositoryInterface):
                $this->getContainer()->singleton(RefreshTokenRepositoryInterface::class, $repository);
                break;
        }
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function run(ServerRequestInterface $request)
    {
        foreach ($this->routes as $route) {
            // If the HTTP method doesn't match then escape early
            if (strtoupper($route->getMethod()) !== strtoupper($request->getMethod())) {
                continue;
            }

            foreach ($route->getQueryStringParameters() as $queryStringParameter) {
                $providedValue = isset($request->getQueryParams()[$queryStringParameter->getKey()])
                    ? $request->getQueryParams()[$queryStringParameter->getKey()]
                    : null;

                $queryStringParameter->evaluate($providedValue);
            }
        }
    }
}
