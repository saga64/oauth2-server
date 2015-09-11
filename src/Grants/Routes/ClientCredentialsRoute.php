<?php

namespace League\OAuth2\Server\Grants\Routes;

use League\OAuth2\Server\Exception\InvalidRequestException;
use League\OAuth2\Server\Util\Value;

class ClientCredentialsRoute implements RouteInterface
{
    /**
     * @inheritdoc
     */
    public function getMethod()
    {
        return 'POST';
    }

    /**
     * @return Value[]
     */
    public function getQueryStringParameters()
    {
        return [];
    }

    /**
     * @return Value[]
     */
    public function getBodyFieldParameters()
    {
        return [
            new Value('grant_type', null, new InvalidRequestException('grant_type')),
            new Value('client_id', null,  new InvalidRequestException('client_id')),
            new Value('client_secret', null,  new InvalidRequestException('client_secret')),
            new Value('grant', ''),
        ];
    }

    /**
     * @return Value[]
     */
    public function getBodyJsonParameters()
    {
        return [];
    }
}
