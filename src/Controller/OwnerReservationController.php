<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\Reservation1Type;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @IsGranted("ROLE_OWNER")
 */
#[Route('/owner/reservation')]
class OwnerReservationController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine)
    {
    }


    #[Route('/', name: 'app_owner_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {

        return $this->render('owner/owner_reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }




    #[Route('/reservation/{id}/confirm', name: 'owner_reservation_confirm')]
    public function confirmReservation(Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $this->doctrine;
        // Set the reservation state to confirmed (e.g., 1)
        $reservation->setState(1);

        // Save the changes to the database
        $entityManager->persist($reservation);
        $entityManager->flush();

        return $this->redirectToRoute('app_reservation_show', ['id' => $reservation->getId()]);
    }

    /**
     * @Route("/reservation/{id}/reject", name="owner_reservation_reject")
     */
    public function rejectReservation(Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $this->doctrine;
        // Set the reservation state to rejected (e.g., 2)
        $reservation->setState(2);

        // Save the changes to the database
        $entityManager->persist($reservation);
        $entityManager->flush();

        return $this->redirectToRoute('app_reservation_show', ['id' => $reservation->getId()]);
    }
}
