<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 22/01/14
 * Time: 19:10
 */

namespace Http;


use Negotiation\Negotiator;

class Request {

    const GET    = 'GET';

    const POST   = 'POST';

    const PUT    = 'PUT';

    const DELETE = 'DELETE';

    private $parameters;

    private $accept_headers;

    public function __construct(array $query = array(), array $request = array(), array $accept_headers = array())
    {
        $this->parameters = array_merge($query, $request);
        $this->accept_headers = $accept_headers;
    }

    public static function createFromGlobals()
    {

        if(isset($_SERVER['HTTP_CONTENT_TYPE']))
        {
            if($_SERVER['HTTP_CONTENT_TYPE'] == 'application/json')
            {
                var_dump("http_content_type");
                $data = file_get_contents('php://input');
                $request = @json_decode($data, true);
                return new self($_GET,$request);
            }
        }
        else if(isset($_SERVER['CONTENT_TYPE']))
        {
            if($_SERVER['HTTP_CONTENT_TYPE'] == 'application/json')
            {
                var_dump("content_type");
                $data = file_get_contents('php://input');
                $request = @json_decode($data, true);
                return new self($_GET,$request);
            }
        }

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

    public function guessBestFormat() {

       // var_dump($this->accept_headers);


       // $negotiator   = new \Negotiation\FormatNegotiator();

        //$acceptHeader = 'application/xml;q=0.9,application/json';
       // $priorities   = array('application/xml', 'application/json','html','*/*');

        //     return $negotiator->getBestFormat($acceptHeader, $priorities);

    }

} 