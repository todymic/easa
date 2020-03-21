<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        $fake = Factory::create();
        $user = new User();

        $user->setEmail('t@t.t');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
        $user->setFirstname($fake->firstName);
        $user->setLastname($fake->lastName);
        $user->setAdresse($fake->address);
        $user->setCity($fake->city);
        $user->setCountry($fake->country);
        $user->setPhone($fake->phoneNumber);
        $user->agreeTerms();

        $manager->persist($user);
        $manager->flush();
    }
}
