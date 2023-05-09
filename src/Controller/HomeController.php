<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Repository\CategoryRepository;
use App\Repository\TerrainRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{


    public function __construct(private ManagerRegistry $doctrine)
    {
    }



    #[Route('/', name: 'app_home')]
    public function index(TerrainRepository $terrainRepository, CategoryRepository $categoryRepository): Response
    {
        $terrain = $terrainRepository->findByDate();
        return $this->render('home/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'terrains' => $terrain,
        ]);
    }



    #[Route('/terrains', name: 'app_terrains')]
    public function showTerrains(TerrainRepository $terrainRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('home/showTerrain.html.twig', [
            'terrains' => $terrainRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }


    #[Route('/terrain/{id}', name: 'app_terrain_show', methods: ['GET'])]
    public function showDetail(Terrain $terrain): Response
    {
        $images = $terrain->getImages();
        return $this->render('home/detailTerrain.html.twig', [
            'images' => $images,
            'terrain' => $terrain,
        ]);
    }
}
