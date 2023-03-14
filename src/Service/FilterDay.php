<?php

namespace App\Service;

use App\Repository\OpeningRepository;

class FilterDay
{
    private OpeningRepository $openingRepository;

    public function __construct(OpeningRepository $openingRepository)
    {
        $this->openingRepository = $openingRepository;
    }

    public const OPENING_DAY = [
        'Lundi'    => 1,
        'Mardi'    => 2,
        'Mercredi' => 3,
        'Jeudi'    => 4,
        'Vendredi' => 5,
        'Samedi'   => 6,
        'Dimanche' => 7,
    ];

    public function openingDayFilter(): array
    {
        $days         = $this->openingRepository->findAll();
        $filteredDays = self::OPENING_DAY;

        foreach ($days as $day) {
            unset($filteredDays[array_search($day->getDay(), self::OPENING_DAY)]);
        }

        return $filteredDays;
    }
}