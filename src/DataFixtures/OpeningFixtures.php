<?php

namespace App\DataFixtures;

use App\Entity\Opening;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OpeningFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i < 8; $i++) {
            $opening = new Opening();
            $opening->setDay($i);
            $opening->setOpenMorning((new \DateTime())->setTime('12', '00', '00'));
            $opening->setCloseMorning((new \DateTime())->setTime('14', '00', '00'));
            $opening->setOpenEvening((new \DateTime())->setTime('19', '00', '00'));
            $opening->setCloseEvening((new \DateTime())->setTime('21', '00', '00'));
            $opening->setIsMorningClosed($faker->boolean());
            $opening->setIsEveningClosed($faker->boolean());
            $manager->persist($opening);
        }

        $manager->flush();
    }
}
