<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testRestrictedWithUnauthorizedUserArea()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

}
