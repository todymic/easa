<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testRestrictedWithUnauthorizedUserArea()
    {


        $crawler = $this->client->request('GET', '/user');

        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }

    public function testSecuredArea()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/user/1');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        //$this->assertSame('Admin Dashboard', $crawler->filter('h1')->text());
    }

    private function logIn()
    {
        $session = self::$container->get('session');

        $firewallName = 'main';
        $firewallContext = 'main';

        $token = new UsernamePasswordToken(new User(), 't@t.t', $firewallName, ['ROLE_USER']);
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

}
