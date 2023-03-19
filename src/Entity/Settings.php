<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingsRepository::class)]
class Settings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $restaurant = null;

    #[ORM\Column]
    private ?int $seats = null;

    #[ORM\Column]
    private ?int $remainingMorningSeats = null;

    #[ORM\Column]
    private ?int $remainingEveningSeats = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeats(): ?int
    {
        return $this->seats;
    }

    public function setSeats(int $seats): self
    {
        $this->seats = $seats;

        return $this;
    }

    public function getRemainingMorningSeats(): ?int
    {
        return $this->remainingMorningSeats;
    }

    public function setRemainingMorningSeats(?int $remainingMorningSeats): Settings
    {
        $this->remainingMorningSeats = $remainingMorningSeats;
        return $this;
    }

    public function getRemainingEveningSeats(): ?int
    {
        return $this->remainingEveningSeats;
    }

    public function setRemainingEveningSeats(?int $remainingEveningSeats): Settings
    {
        $this->remainingEveningSeats = $remainingEveningSeats;
        return $this;
    }


    public function getRestaurant(): ?string
    {
        return $this->restaurant;
    }

    public function setRestaurant(?string $restaurant): Settings
    {
        $this->restaurant = $restaurant;
        return $this;
    }
}
