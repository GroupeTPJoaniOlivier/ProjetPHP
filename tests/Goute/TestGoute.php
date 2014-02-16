<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 16/02/14
 * Time: 22:33
 */

namespace GouteTest;

use Goutte\Client;
use TestCase;

class TestGoute extends TestCase{

    private $client;
    private $endpoint;

    public function setUp()
    {
        $this->client = new Client();
        $this->endpoint = "http://localhost:8080";

    }

    public function testGetHome() {
        $this->client->request('GET', sprintf('%s/statuses', $this->endpoint));
        $resp = $this->client->getResponse();
        $this->assertEquals(200, $resp->getStatus());
    }

    // Status with  id 2021164721 must exists
    public function testGetStatusWithId() {

        $this->client->request('GET', sprintf('%s/statuses/2021164721', $this->endpoint));
        $resp = $this->client->getResponse();
        $this->assertEquals(200, $resp->getStatus());
    }

} 