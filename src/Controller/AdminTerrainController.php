<?php

namespace App\Controller;

use App\Repository\TerrainRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @IsGranted("ROLE_ADMIN")
 */
#[Route('/admin/terrain')]
class AdminTerrainController extends AbstractController
{

    #[Route('/', name: 'app_admin_terrain_index', methods: ['GET'])]
    public function index(TerrainRepository $terrainRepository): Response
    {
        return $this->render('admin/admin_terrain/index.html.twig', [
            'terrains' => $terrainRepository->findAll(),
        ]);
    }
}
