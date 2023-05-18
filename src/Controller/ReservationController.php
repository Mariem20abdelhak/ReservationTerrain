<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Terrain;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\TerrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class ReservationController extends AbstractController
{


    public function __construct(private ManagerRegistry $doctrine)
    {
    }
    #[Route('/create/reservation/{id}', name: 'app_reservation_create',  methods: ['GET', 'POST'])]
    public function CreateReservation(Security $security, Request $request, Terrain $terrain, EntityManagerInterface $entityManager, TerrainRepository $terrainRepository, int $id, ReservationRepository $reservationRepository): Response
    {
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


            // Redirect to the reservation success page
            return $this->redirectToRoute('app_reservation_show', ['id' => $reservation->getId()]);
        }


        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView(),
            'images' => $images,
            'terrain' => $terrain,
        ]);
    }




    #[Route('/reservation/{id}', name: 'app_reservation_show',  methods: ['GET', 'POST'])]
    public function show(Reservation $reservation)
    {

        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }
}
