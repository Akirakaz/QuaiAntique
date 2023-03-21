<?php

namespace App\DataFixtures;

use App\Entity\Meal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MealFixtures extends Fixture
{
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $meal = new Meal();
            $meal->setTitle($faker->sentence(3));
            $meal->setDescription($faker->sentence(5));
            $meal->setPrice($faker->randomFloat(0, 10, 20));
            $meal->setCategory(random_int(0, 3));
            $manager->persist($meal);
        }

        $manager->flush();
    }
}
