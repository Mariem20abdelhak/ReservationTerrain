<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\TerrainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(TerrainRepository $terrainRepository, Request $request): Response
    {
        $terrain  = $terrainRepository->findAll();
        $search = new SearchType(); //Entity sans enregistrement dans la BD
        $form = $this->createForm(SearchType::class, $search); //il faut encapsuler les choix du formulaire dans une entité sans reporitory, objet métier
        //quand le formulaire est soumis
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $terrain = $terrainRepository->findWithSearch($search);
        }
        return $this->render('home/index.html.twig', [
            'terrains' => $terrain,
            'search' => $form->createView()
        ]);
    }
}
