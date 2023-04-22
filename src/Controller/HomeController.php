<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\TerrainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TerrainRepository $terrainRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'terrains' => $terrainRepository->findAll(),
        ]);
    }
}
