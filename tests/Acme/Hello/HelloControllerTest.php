<?php

namespace Acme\Hello;

use Acme\WebTestCase;

class HelloControllerTest extends WebTestCase
{
    public function testHelloWorld()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/hello-world');

        $this->assertEquals(
            'Hello World!',
            $client->getResponse()->getContent()
        );
    }

    public function testHelloTwig()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/hello-twig');

        $this->assertEquals(
            'Hello World!',
            $crawler->filter('p.hello')->text()
        );
    }
}
