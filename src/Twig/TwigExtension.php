<?php

namespace App\Twig;

use App\Repository\OpeningRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension
{
    private RequestStack      $request;
    private OpeningRepository $openingRepository;

    public function __construct(OpeningRepository $openingRepository, RequestStack $requestStack,)
    {
        $this->openingRepository = $openingRepository;
        $this->request           = $requestStack;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('boolIconFormater', [$this, 'boolIconFormater']),
            new TwigFilter('renameDay', [$this, 'renameDay']),
            new TwigFilter('renameCategory', [$this, 'renameCategory']),
            new TwigFilter('formatPhone', [$this, 'formatPhoneNumber']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('showOpening', [$this, 'getOpeningDays']),
            new TwigFunction('isMenuActive', [$this, 'isMenuActive']),
            new TwigFunction('setColor', [$this, 'setColor']),
        ];
    }

    //-- Filters

    public function boolIconFormater(bool $state): string
    {
        if ($state) {
            return <<< END
            <svg viewBox="0 0 16 16" width="16" height="16"><path fill="#0C8544" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/></svg>
            END;
        } else {
            return <<< END
            <svg viewBox="0 0 16 16" width="16" height="16"><path fill="#EF4444" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/></svg>
           END;
        }
    }

    public function renameDay($day): ?string
    {
        $days = [
            1 => 'Lundi',
            2 => 'Mardi',
            3 => 'Mercredi',
            4 => 'Jeudi',
            5 => 'Vendredi',
            6 => 'Samedi',
            7 => 'Dimanche',
        ];

        if (array_key_exists($day, $days)) {
            return $days[$day];
        }

        return null;
    }

    public function renameCategory(string $category): ?string
    {
        $categories = [
            0 => 'Entrées',
            1 => 'Plats',
            2 => 'Desserts',
        ];

        if (array_key_exists($category, $categories)) {
            return $categories[$category];
        }

        return null;
    }

    function formatPhoneNumber(?string $phoneNumber): string
    {
        return $phoneNumber ? implode(' ', str_split($phoneNumber, 2)) : '--';
    }

    //-- Functions

    public function getOpeningDays(): array
    {
        $openingHoursRepository = $this->openingRepository;
        return $openingHoursRepository->findAll();
    }

    public function isMenuActive(array $routes, ?string $classes = 'active', ?string $default = null): ?string
    {
        $currentRoute = $this->request->getCurrentRequest()->attributes->get('_route');

        if (in_array($currentRoute, $routes, true)) {
            return $classes;
        }

        return $default;
    }

    public function setColor(string $color): ?string
    {
        return match ($color) {
            'succès'    => 'green',
            'erreur'    => 'red',
            'attention' => 'yellow',
            'info'      => 'blue',
        };
    }
}