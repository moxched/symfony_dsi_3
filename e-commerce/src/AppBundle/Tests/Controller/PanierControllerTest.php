<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PanierControllerTest extends WebTestCase
{
    public function testAddtocart()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addtocart');
    }

}
