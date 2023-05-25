<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Entity\Reservation;
use App\Entity\Terrain;
use App\Form\ReservationType;
use App\Repository\CalendarRepository;
use App\Repository\ReservationRepository;
use App\Repository\TerrainRepository;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class ReservationController extends AbstractController
{

    private $security;
    public function __construct(private ManagerRegistry $doctrine, Security $security)
    {
        $this->security = $security;
    }
    #[Route('/create/reservation/{id}', name: 'app_reservation_create',  methods: ['GET', 'POST'])]
    public function CreateReservation(UrlGeneratorInterface $urlGenerator, CalendarRepository $calendar, Security $security, Request $request, Terrain $terrain, EntityManagerInterface $entityManager, TerrainRepository $terrainRepository, int $id, ReservationRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findBy(['terrain' => $terrain]);
        $endpointUrl = $urlGenerator->generate('app_reservation_create', ['id' => $terrain->getId()]);
        $events = $calendar->findBy(['terrain' => $terrain]);
        $rdvs = [];
        foreach ($events as $event) {
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
                'allDay' => $event->isAllDay(),
            ];
        }


        // Fetch the terrain entity based on the terrain ID
        $terrain = $terrainRepository->find($id);
        $images = $terrain->getImages();
        $reservation = new Reservation();
        $this->doctrine;
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$security->isGranted('IS_AUTHENTICATED_FULLY')) {
                // Redirect the user to the login page or display an error message
                throw new AccessDeniedException('You must be logged in to make a reservation.');
            }
            if (!$this->security->isGranted('ROLE_USER')) {
                throw new AccessDeniedException('Access denied. User does not have the required role.');
            }
            // Assuming you have a logged-in user, set the user to the reservation
            $user = $this->getUser();
            $reservation->setClient($user);
            $reservation->setTerrain($terrain);

            // Calculate and set the total price based on the selected terrain and duration
            $Date = $form->get('date')->getData();

            $reservation->setDate($Date);
            $reservation->setState(0);
            $price = $terrain->getPrice();
            $reservation->setPrice($price);

            // Persist the reservation to the database
            $entityManager->persist($reservation);
            $entityManager->flush();

            //create a calendar
            $calendar = new Calendar();

            //set end of reservation date

            //add playing time
            $playingTime = $terrain->getHours()->format('H:i:s');
            $timePartsPlay = explode(':', $playingTime);
            $hoursPlay = intval($timePartsPlay[0]);
            $minutesPlay = intval($timePartsPlay[1]);
            $timeToAddPlay = new DateInterval('PT' . $hoursPlay . 'H' . $minutesPlay . 'M');

            //add pause time
            $pauseTime = $terrain->getPause()->format('H:i:s');
            $timePartsPause = explode(':', $pauseTime);
            $hoursPause = intval($timePartsPause[0]);
            $minutesPause = intval($timePartsPause[1]);
            $timeToAddPause = new DateInterval('PT' . $hoursPause . 'H' . $minutesPause . 'M');



            $Date = $reservation->getDate()->format('Y-m-d H:i:s');

            $end = new DateTime($Date);

            $end->add($timeToAddPlay);
            $end->add($timeToAddPause);
            $Date = new DateTime($Date);

            //set calender 
            $calendar->setStart($Date);
            $calendar->setEnd($end);
            $calendar->setBackgroundColor('#c4eed0');
            $calendar->setBorderColor('#000');
            $calendar->setTextColor('#000');
            $calendar->setAllDay(0);
            $calendar->setTerrain($terrain);

            // Persist the reservation to the database
            $entityManager->persist($calendar);
            $entityManager->flush();

            // Redirect to the reservation success page
            return $this->redirectToRoute('app_reservation_show', ['id' => $reservation->getId()]);
        }

        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView(),
            'images' => $images,
            'terrain' => $terrain,
            'data' => json_encode($rdvs),
            'reservations' => $reservations,
            'endPoint' => $endpointUrl,
        ]);
    }




    #[Route('/reservation/{id}', name: 'app_reservation_show',  methods: ['GET', 'POST'])]
    public function show(Reservation $reservation)
    {

        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }




    #[Route('/user/reservations', name: 'app_reservation_show_client')]
    public function showReservationsByUserId(ReservationRepository $reservationRepository): Response
    {
        $user = $this->getUser();

        // Render the reservations using a template
        return $this->render('user/myReservation.html.twig', [
            'reservations' => $reservationRepository->findByClient($user),
        ]);
    }
}
