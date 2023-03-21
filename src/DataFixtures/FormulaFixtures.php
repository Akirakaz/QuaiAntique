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

        for ($j = 0; $j < 3; $j++) {
            $menu = new Menu();
            $menu->setTitle($faker->sentence(3));
            $manager->persist($menu);

            for ($i = 0; $i < 3; $i++) {
                $formula = new Formula();
                $formula->setTitle($faker->sentence(3));
                $formula->setDescription($faker->sentence(5));
                $formula->setPrice($faker->randomFloat(0, 25, 50));
                $formula->setStarter($faker->boolean());
                $formula->setMain($faker->boolean());
                $formula->setDessert($faker->boolean());
                $formula->setMenu($menu);
                $manager->persist($formula);
            }
        }

        $manager->flush();
    }
}
