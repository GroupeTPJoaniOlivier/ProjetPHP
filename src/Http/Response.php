<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 28/01/14
 * Time: 15:10
 */

namespace Http;

class Response
{
    private $content;

    private $statusCode;

    private $headers;

    public function __construct($content, $statusCode = 200, array $headers = [])
    {
        $this->content    = $content;
        $this->statusCode = $statusCode;
        // Access-Control-Allow-Origin added for cross domain AJAX request testing
        $this->headers    = array_merge([ 'Content-Type' => 'text/html', 'Access-Control-Allow-Origin' => '*' ], $headers);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }


    public function getContent()
    {
        return $this->content;
    }

    public function sendHeaders()
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header(sprintf('%s: %s', $name, $value));
        }
    }

    public function send()
    {
        $this->sendHeaders();

        echo $this->content;
    }
}