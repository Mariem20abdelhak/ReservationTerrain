<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Form\TerrainFormType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/owner', name: 'owner_')]
class OwnerController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('owner/index.html.twig', [
            'controller_name' => 'OwnerController',
        ]);
    }
    #[Route('/add/terrain', name: 'terrain_add')]
    public function add_terrain(Request $request, EntityManagerInterface $entityManager)
    {
        $terrain = new Terrain;
        $form = $this->createForm(TerrainFormType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine;
            $terrain->setUser($this->getUser());

            $entityManager->persist($terrain);
            $entityManager->flush();

            return $this->redirectToRoute('owner_home');
        }

        return $this->render('owner/terrain/addTerrain.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/view/terrain/', name: 'view_terrain')]
    public function viewTerrain(EntityManagerInterface $entityManager): Response
    {
        $this->doctrine;
        $user = $this->getUser();
        $terrain =  $entityManager->getRepository(Terrain::class)->findByUser($user);
        return $this->render('owner/terrain/viewTerrain.html.twig', [
            'terrains' => $terrain,
        ]);
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
            return $this->redirectToRoute('owner_home');
        }

        return $this->render('user/editProfile.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
