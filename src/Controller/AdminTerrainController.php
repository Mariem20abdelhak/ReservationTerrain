<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Terrain;
use App\Form\TerrainType;
use App\Repository\TerrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @IsGranted("ROLE_ADMIN")
 */
#[Route('/admin/terrain')]
class AdminTerrainController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine)
    {
    }



    #[Route('/', name: 'app_admin_terrain_index', methods: ['GET'])]
    public function index(TerrainRepository $terrainRepository): Response
    {
        return $this->render('admin/admin_terrain/index.html.twig', [
            'terrains' => $terrainRepository->findAll(),
        ]);
    }
}
