<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BookingFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $booking = new Booking();
            $booking->setBookingName($faker->name);
            $booking->setPhone($faker->serviceNumber());
            $booking->setEmail($faker->email);
            $booking->setGuests($faker->numberBetween(1,8));
            $booking->setAllergies($faker->text());
            $booking->setDate(new \DateTime());
            $booking->setHour((new \DateTime())->setTime('12', '00', '00'));
            $manager->persist($booking);
        }

        $manager->flush();
    }
}
