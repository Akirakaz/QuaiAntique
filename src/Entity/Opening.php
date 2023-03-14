<?php

namespace App\Entity;

use App\Repository\OpeningRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpeningRepository::class)]
class Opening
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?int $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $openMorning = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $closeMorning = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $openEvening = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $closeEvening = null;

    #[ORM\Column]
    private ?bool $isMorningClosed = null;

    #[ORM\Column]
    private ?bool $isEveningClosed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(int $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getOpenMorning(): ?\DateTimeInterface
    {
        return $this->openMorning;
    }

    public function setOpenMorning(?\DateTimeInterface $openMorning): self
    {
        $this->openMorning = $openMorning;

        return $this;
    }

    public function getCloseMorning(): ?\DateTimeInterface
    {
        return $this->closeMorning;
    }

    public function setCloseMorning(?\DateTimeInterface $closeMorning): self
    {
        $this->closeMorning = $closeMorning;

        return $this;
    }

    public function getOpenEvening(): ?\DateTimeInterface
    {
        return $this->openEvening;
    }

    public function setOpenEvening(?\DateTimeInterface $openEvening): self
    {
        $this->openEvening = $openEvening;

        return $this;
    }

    public function getCloseEvening(): ?\DateTimeInterface
    {
        return $this->closeEvening;
    }

    public function setCloseEvening(?\DateTimeInterface $closeEvening): self
    {
        $this->closeEvening = $closeEvening;

        return $this;
    }

    public function isMorningClosed(): ?bool
    {
        return $this->isMorningClosed;
    }

    public function setIsMorningClosed(bool $isMorningClosed): self
    {
        $this->isMorningClosed = $isMorningClosed;

        return $this;
    }

    public function isEveningClosed(): ?bool
    {
        return $this->isEveningClosed;
    }

    public function setIsEveningClosed(bool $isEveningClosed): self
    {
        $this->isEveningClosed = $isEveningClosed;

        return $this;
    }
}
