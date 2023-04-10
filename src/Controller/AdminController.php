<?php

namespace App\Controller;

use App\Form\EditProfileType;
use App\Entity\User;
use App\Entity\Category;
use App\Form\CategoriesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;



#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/add/category', name: 'category_add')]
    public function AddCategory(Request $request, EntityManagerInterface $entityManager)
    {

        $category = new Category;
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine;
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('admin_home');
        }


        return $this->render('admin/category/add.html.twig', [
            'form' => $form->createView()
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
            return $this->redirectToRoute('admin_home');
        }

        return $this->render('user/editProfile.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
