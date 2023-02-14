<?php

namespace App\Entity;

use App\Repository\OpeningHoursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpeningHoursRepository::class)]
class OpeningHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $days = null;

    #[ORM\Column]
    private ?int $openLunch = null;

    #[ORM\Column]
    private ?int $closeLunch = null;

    #[ORM\Column]
    private ?int $openDinner = null;

    #[ORM\Column]
    private ?int $closeDinner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDays(): ?string
    {
        return $this->days;
    }

    public function setDays(string $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getOpenLunch(): ?int
    {
        return $this->openLunch;
    }

    public function setOpenLunch(int $openLunch): self
    {
        $this->openLunch = $openLunch;

        return $this;
    }

    public function getCloseLunch(): ?int
    {
        return $this->closeLunch;
    }

    public function setCloseLunch(int $closeLunch): self
    {
        $this->closeLunch = $closeLunch;

        return $this;
    }

    public function getOpenDinner(): ?int
    {
        return $this->openDinner;
    }

    public function setOpenDinner(int $openDinner): self
    {
        $this->openDinner = $openDinner;

        return $this;
    }

    public function getCloseDinner(): ?int
    {
        return $this->closeDinner;
    }

    public function setCloseDinner(int $closeDinner): self
    {
        $this->closeDinner = $closeDinner;

        return $this;
    }
}
