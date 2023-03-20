<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ImageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $image = new Image();
            $image->setImageFile($faker->image(null,640, 480));
            $image->setImageName($faker->name);
            $image->setTitle($faker->title);
            $image->setDescription($faker->sentence());
            // $manager->persist($image);
        }
        dd($image);
        $manager->flush();
    }
}
