<?php

namespace App\DataFixtures;

use App\Entity\MealCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CreateCategoriesFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['categories'];
    }

    public function load(ObjectManager $manager): void
    {
        $defaultCategories = [
          'Entrée',
          'Plat',
          'Dessert',
          'Boisson'
        ];

        foreach ($defaultCategories as $category) {
            $mealCategory = new MealCategory();
            $mealCategory->setName($category);

            $manager->persist($mealCategory);
        }

        $manager->flush();
    }
}
