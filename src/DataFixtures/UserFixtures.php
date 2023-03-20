<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\fr_FR\PhoneNumber;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setBookingName($faker->name);
            $user->setPhone(PhoneNumber::numerify('047#######'));
            $user->setEmail($faker->email);
            $user->setPassword($faker->password());
            $user->setGuests($faker->numberBetween(1, 8));
            $user->setAllergies($faker->text);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
