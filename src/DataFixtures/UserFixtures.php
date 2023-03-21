<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\fr_FR\PhoneNumber;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@demo.com');
        $user->setPassword($this->hasher->hashPassword($user, 'admin_password'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $user = new User();
        $user->setBookingName('Jane Doesnt');
        $user->setPhone(PhoneNumber::numerify('0479123456'));
        $user->setEmail('user@demo.com');
        $user->setPassword($this->hasher->hashPassword($user, 'user_password'));
        $user->setGuests(2);
        $user->setAllergies('Aucunes');
        $user->setRoles(['ROLE_CLIENT']);
        $manager->persist($user);

        $manager->flush();
    }
}
