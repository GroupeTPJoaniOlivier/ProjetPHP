<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 22/01/14
 * Time: 19:10
 */

namespace Http;


class Request {

    const GET    = 'GET';

    const POST   = 'POST';

    const PUT    = 'PUT';

    const DELETE = 'DELETE';

    private $parameters;

    public function __construct(array $query = array(), array $request = array())
    {
        $this->parameters = array_merge($query, $request);
    }

    public static function createFromGlobals()
    {
        return new self($_GET,$_POST);
    }

    public function getParameter($name, $default = null)
    {
        if(array_key_exists($name, $this->parameters))
        {
            return $this->parameters[$name];
        }

        return $default;
    }

    public function getMethod()
    {
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : Request::GET;

        if ($method === self::POST) {
            return $this->getParameter('_method', $method);
        }

        return $method;
    }

    public function getUri()
    {
        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

        if ($pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        return $uri;
    }

} 