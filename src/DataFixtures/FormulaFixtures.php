<?php

namespace App\DataFixtures;

use App\Entity\Formula;
use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FormulaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $menu = new Menu();

        for ($j = 0; $j < 4; $j++) {
            $menu->setTitle($faker->title);
            $manager->persist($menu);
        }

        for ($i = 0; $i < 10; $i++) {
            $formula = new Formula();
            $formula->setTitle($faker->title);
            $formula->setDescription($faker->sentence());
            $formula->setPrice($faker->randomNumber());
            $formula->setStarter($faker->boolean());
            $formula->setMain($faker->boolean());
            $formula->setDessert($faker->boolean());
            $formula->setMenu($menu->getTitle());
            $manager->persist($formula);
        }

        $manager->flush();
    }
}
