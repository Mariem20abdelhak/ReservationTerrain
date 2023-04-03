<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Form\TerrainFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
}
