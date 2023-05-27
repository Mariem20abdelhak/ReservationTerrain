<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

/**
 * @IsGranted("ROLE_ADMIN")
 */
#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
    #[Route('/edit/profile', name: 'profile_edit')]
    public function edit_profile(Request $request, EntityManagerInterface $entityManager)
    {
        $this->doctrine;
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->getRepository(User::class);
            $entityManager->persist($user);
            $entityManager->flush();


            $this->addFlash('message', 'Your profile was edited successfully.');
            return $this->redirectToRoute('admin_home');
        }

        return $this->render('user/editProfile.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
