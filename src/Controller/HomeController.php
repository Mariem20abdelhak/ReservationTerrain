<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Terrain;
use App\Form\SearchType;
use App\Repository\CategoryRepository;
use App\Repository\TerrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }
    #[Route('/', name: 'app_home')]
    public function index(TerrainRepository $terrainRepository, CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        //to get terrain
        $terrains = $terrainRepository->findAll();
        $chunks_terrain = array_chunk($terrains, 3);
        //to get category
        $categories = $categoryRepository->findAll();
        $chunks_categories = array_chunk($categories, 3);
        //to make search
        $this->doctrine;
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $results = [];
        if ($form->isSubmitted() && $form->isValid()) {
            // Retrieve search parameters
            $adresse = $form->get('adresse')->getData();
            $category = $form->get('category')->getData();
            // Perform search query based on the provided parameters
            $repository = $entityManager->getRepository(Terrain::class);
            $results = $repository->findBy([
                'adresse' => $adresse,
                'category' => $category,
            ]);
            return $this->render('home/search.html.twig', [
                'results' => $results,
            ]);
        }
        return $this->render('home/index.html.twig', [
            'chunks_categories' => $chunks_categories,
            'terrains' => $terrains,
            'categories' => $categories,
            'chunks_terrain' => $chunks_terrain,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/category/{id}', name: 'app_category_show', methods: ['GET'])]
    public function showTerrainsByCategory(Category $category, TerrainRepository $terrainRepository): Response
    {
        $this->doctrine;
        $terrains = $terrainRepository->findBy(['category' => $category]);
        return $this->render('home/terrains_by_category.html.twig', [
            'terrains' => $terrains,
            'category' => $category,
        ]);
    }
}
