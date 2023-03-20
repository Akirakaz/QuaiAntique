<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    use TimestampableEntity;

    public const GUESTS = [
        '1 à 2' => 2,
        '3 à 4' => 4,
        '5 à 6' => 6,
        '7 à 8' => 8,
    ];

    public const MINUTES = [00, 15, 30, 45];
    public const HOURS   = [12, 13, 19, 20];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $bookingName = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?int $guests = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $allergies = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?DateTimeInterface $hour = null;

    #[ORM\ManyToOne(inversedBy: 'booking')]
    private ?BookingDay $bookingDay = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Booking
    {
        $this->id = $id;
        return $this;
    }

    public function getBookingName(): ?string
    {
        return $this->bookingName;
    }

    public function setBookingName(?string $bookingName): Booking
    {
        $this->bookingName = $bookingName;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): Booking
    {
        $this->phone = $phone;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): Booking
    {
        $this->email = $email;
        return $this;
    }

    public function getGuests(): ?int
    {
        return $this->guests;
    }

    public function setGuests(?int $guests): Booking
    {
        $this->guests = $guests;
        return $this;
    }

    public function getAllergies(): ?string
    {
        return $this->allergies;
    }

    public function setAllergies(?string $allergies): Booking
    {
        $this->allergies = $allergies;
        return $this;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?DateTimeInterface $date): Booking
    {
        $this->date = $date;
        return $this;
    }

    public function getHour(): ?DateTimeInterface
    {
        return $this->hour;
    }

    public function setHour(?DateTimeInterface $hour): Booking
    {
        $this->hour = $hour;
        return $this;
    }

    public function getBookingDay(): ?BookingDay
    {
        return $this->bookingDay;
    }

    public function setBookingDay(?BookingDay $bookingDay): self
    {
        $this->bookingDay = $bookingDay;

        return $this;
    }
}
