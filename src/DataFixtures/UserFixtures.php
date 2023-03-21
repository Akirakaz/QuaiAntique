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
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setEmail('admin@demo.com');
        $user->setPassword($this->hasher->hashPassword($user, 'admin_password'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $user = new User();
        $user->setBookingName($faker->name);
        $user->setPhone(PhoneNumber::numerify('047#######'));
        $user->setEmail('user@demo.com');
        $user->setPassword($this->hasher->hashPassword($user, 'user_password'));
        $user->setGuests($faker->numberBetween(1, 8));
        $user->setAllergies($faker->text);
        $user->setRoles(['ROLE_CLIENT']);
        $manager->persist($user);

        $manager->flush();
    }
}
