<?php

namespace App\DataFixtures;

use App\Entity\Meal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MealFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $meal = new Meal();
            $meal->setTitle($faker->title);
            $meal->setDescription($faker->sentence());
            $meal->setPrice($faker->randomFloat(2,0,25));
            $meal->setCategory(random_int(1,3));
            $manager->persist($meal);
        }

        $manager->flush();
    }
}
