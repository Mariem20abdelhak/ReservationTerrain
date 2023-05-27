<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }
    #[Route('/edit/profile', name: 'profile_edit')]
    public function edit_profile(Request $request, EntityManagerInterface $entityManager)
    {
        $this->doctrine;
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->getRepository(User::class);
            $entityManager->persist($user);
            $entityManager->flush();


            $this->addFlash('message', 'Your profile was edited successfully.');
            return $this->redirectToRoute('user_home');
        }

        return $this->render('user/editProfile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/reservations', name: 'reservation_show')]
    public function showReservationsByUserId(ReservationRepository $reservationRepository): Response
    {
        $user = $this->getUser();

        // Render the reservations using a template
        return $this->render('user/myReservation.html.twig', [
            'reservations' => $reservationRepository->findByClient($user),
        ]);
    }
}
