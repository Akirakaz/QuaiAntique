<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MenuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 6; $i++) {
            $menu = new Menu();
            $menu->setTitle($faker->title);
            $manager->persist($menu);
        }

        $manager->flush();
    }
}
