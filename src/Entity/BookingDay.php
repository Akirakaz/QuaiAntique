<?php

namespace App\Entity;

use App\Repository\BookingDayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: BookingDayRepository::class)]
class BookingDay
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $remainingMorningSeats = null;

    #[ORM\Column]
    private ?int $remainingEveningSeats = null;

    #[ORM\OneToMany(mappedBy: 'bookingDay', targetEntity: Booking::class)]
    private Collection $booking;

    public function __construct()
    {
        $this->booking = new ArrayCollection();
    }

    public function getRemainingMorningSeats(): ?int
    {
        return $this->remainingMorningSeats;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setRemainingMorningSeats(?int $remainingMorningSeats): BookingDay
    {
        $this->remainingMorningSeats = $remainingMorningSeats;
        return $this;
    }

    public function getRemainingEveningSeats(): ?int
    {
        return $this->remainingEveningSeats;
    }

    public function setRemainingEveningSeats(?int $remainingEveningSeats): BookingDay
    {
        $this->remainingEveningSeats = $remainingEveningSeats;
        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBooking(): Collection
    {
        return $this->booking;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->booking->contains($booking)) {
            $this->booking->add($booking);
            $booking->setBookingDay($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->booking->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getBookingDay() === $this) {
                $booking->setBookingDay(null);
            }
        }

        return $this;
    }
}