<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use App\Repository\SettingsRepository;
use DateInterval;
use DatePeriod;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/booking')]
class BookingController extends AbstractController
{
//    #[Route('/', name: 'app_booking', methods: ['GET'])]
//    public function index(BookingRepository $bookingRepository): Response
//    {
//        return $this->render('public/booking/index.html.twig', [
//            'bookings' => $bookingRepository->findAll(),
//        ]);
//    }

    #[Route('/', name: 'app_booking', methods: ['GET', 'POST'])]
    public function new(Request $request, BookingRepository $bookingRepository, SettingsRepository $settingsRepository): Response
    {
        $rangeMorning = new DatePeriod(
            new DateTime('12:00:00'),
            new DateInterval('P1M'),
            new DateTime('13:45:00'),
        );

        $rangeEvening = new DatePeriod(
            new DateTime('12:00:00'),
            new DateInterval('P1M'),
            new DateTime('20:45:00'),
        );

//        dump($bookingRepository->countGuestsForRange($rangeMorning));
        //dd($bookingRepository->countGuestsForRange($rangeEvening));
        $booking = new Booking();
        $user = $this->getUser();

        if ($user) {
            $booking
                ->setBookingName($user->getBookingName())
                ->setPhone($user->getPhone())
                ->setEmail($user->getEmail())
                ->setGuests($user->getGuests())
                ->setAllergies($user->getAllergies());
        }

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$settings       = $settingsRepository->findOneBy(['restaurant' => 'QuaiAntique']);
            //$remainingSeats = ($settings->getSeats() - $booking->getGuests());
            //$settings->setRemainingMorningSeats($remainingSeats);

            $bookingRepository->save($booking, true);
            //$settingsRepository->save($settings);

            return $this->redirectToRoute('app_booking', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('public/booking/index.html.twig', [
            'booking' => $booking,
            'form'    => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_booking_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Booking $booking, BookingRepository $bookingRepository): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookingRepository->save($booking, true);

            return $this->redirectToRoute('app_booking', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('public/booking/edit.html.twig', [
            'booking' => $booking,
            'form'    => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_delete', methods: ['POST'])]
    public function delete(Request $request, Booking $booking, BookingRepository $bookingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $booking->getId(), $request->request->get('_token'))) {
            $bookingRepository->remove($booking, true);
        }

        return $this->redirectToRoute('app_booking', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @throws \Exception
     */
    #[Route('/seats', name: 'app_booking_get_seats', methods: ['GET'])]
    public function getRemainingSeats(Request $request, BookingRepository $bookingRepository, SettingsRepository $settingsRepository): JsonResponse
    {
        $hour = $request->query->get('bookingHour');

        if ($hour >= '12' && $hour < '14') {
            $range = new DatePeriod(
                new DateTime('12:00:00'),
                new DateInterval('P1M'),
                new DateTime('14:00:00'),
            );
        } else {
            $range = new DatePeriod(
                new DateTime('19:00:00'),
                new DateInterval('P1M'),
                new DateTime('21:00:00'),
            );
        }

        $settings   = $settingsRepository->findOneBy(['restaurant' => 'QuaiAntique']);
        $totalSeats = $settings->getSeats();
        $date       = new DateTime($request->query->get('bookingDate'));
        $usedSeats  = $bookingRepository->countGuestsForRange($range, $date);
        $reserved   = $usedSeats ?: 0;


        $availableSeats = ($totalSeats - $reserved);

        return $this->json($availableSeats, 200);
    }
}
