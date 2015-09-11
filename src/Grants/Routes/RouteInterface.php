<?php

namespace League\OAuth2\Server\Grants\Routes;

use League\OAuth2\Server\Util\Value;

interface RouteInterface
{
    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return Value[]
     */
    public function getQueryStringParameters();

    /**
     * @return Value[]
     */
    public function getBodyFieldParameters();

    /**
     * @return Value[]
     */
    public function getBodyJsonParameters();
}
