<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Form\TerrainType;
use App\Repository\TerrainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/owner/terrain')]
class OwnerTerrainController extends AbstractController
{
    #[Route('/', name: 'app_owner_terrain_index', methods: ['GET'])]
    public function index(TerrainRepository $terrainRepository): Response
    {
        $user = $this->getUser();
        return $this->render('owner/owner_terrain/index.html.twig', [
            'terrains' => $terrainRepository->findByUser($user),
        ]);
    }

    #[Route('/new', name: 'app_owner_terrain_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TerrainRepository $terrainRepository): Response
    {
        $terrain = new Terrain();
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //recuperation d'image transmise
            $images = $form->get('image')->getData();
            // on boucle sur les images
            foreach ($images as $image) {
                //on genere un nouveau nom au fichier 
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                //on copie les fichier dans le fichier images
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                //on stocke les image dans la bd
                $terrain->setImage($fichier);
            }
            $terrain->setUser($this->getUser());
            $terrainRepository->save($terrain, true);

            return $this->redirectToRoute('app_owner_terrain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('owner/owner_terrain/new.html.twig', [
            'terrain' => $terrain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_owner_terrain_show', methods: ['GET'])]
    public function show(Terrain $terrain): Response
    {
        return $this->render('owner/owner_terrain/show.html.twig', [
            'terrain' => $terrain,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_owner_terrain_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Terrain $terrain, TerrainRepository $terrainRepository): Response
    {
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //recuperation d'image transmise
            $images = $form->get('image')->getData();
            // on boucle sur les images
            foreach ($images as $image) {
                //on genere un nouveau nom au fichier 
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                //on copie les fichier dans le fichier images
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                //on stocke les image dans la bd
                $terrain->setImage($fichier);
            }
            $terrainRepository->save($terrain, true);

            return $this->redirectToRoute('app_owner_terrain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('owner/owner_terrain/edit.html.twig', [
            'terrain' => $terrain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_owner_terrain_delete', methods: ['POST'])]
    public function delete(Request $request, Terrain $terrain, TerrainRepository $terrainRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $terrain->getId(), $request->request->get('_token'))) {
            $image = $terrain->getImage();
            unlink($this->getParameter('images_directory') . '/' . $image);

            $terrainRepository->remove($terrain, true);
        }

        return $this->redirectToRoute('app_owner_terrain_index', [], Response::HTTP_SEE_OTHER);
    }
}
