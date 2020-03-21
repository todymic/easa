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
    /**
     * @var \Doctrine\ORM\EntityManager|object|null
     */
    private $manager;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testRestrictedWithUnauthorizedUserArea()
    {
        $this->client = static::createClient();

        $crawler = $this->client->request('GET', '/user/');

        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }

    public function testSecuredArea()
    {
        $this->logIn();

        $user = $this->manager->getRepository(User::class)->findOneByEmail('t@t.t');

        $crawler = $this->client->request('GET', '/user/' .$user->getId());

        $response = $this->client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }

    private function logIn()
    {
        $session = self::$container->get('session');

        $firewallName = 'main';
        $firewallContext = 'main';

        $user = $this->manager->getRepository(User::class)->findOneByEmail('t@t.t');

        $token = new UsernamePasswordToken($user, 'test', $firewallName, ['ROLE_USER']);
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

}
