<?php

namespace App\DataFixtures;

use App\Entity\Settings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SettingsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $settings = new Settings();
        $settings->setSeats($faker->numberBetween(40, 60));
        $settings->setRestaurant('QuaiAntique');
        $manager->persist($settings);

        $manager->flush();
    }
}
