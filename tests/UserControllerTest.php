<?php

namespace App\Tests;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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

        $response = $this->client->getResponse();
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }

    private function logIn()
    {
        $session = self::$container->get('session');
        $manager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $firewallName = 'main';
        $firewallContext = 'main';

        $user = $manager->getRepository(User::class)->findOneByEmail('t@t.t');

        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallName, ['ROLE_USER']);
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

}
