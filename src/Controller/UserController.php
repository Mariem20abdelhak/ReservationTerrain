<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    #[Route('/', name: 'home')]
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        return $this->render('user/index.html.twig', [$user]);
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
            return $this->redirectToRoute('user_home');
        }

        return $this->render('user/editProfile.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/edit/password', name: 'password_edit')]
    public function edit_password(Request $request, UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $form = $this->createForm(Editpassword::class, $user);
        $form->handleRequest($request);

        return $this->render('user/editPass.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
