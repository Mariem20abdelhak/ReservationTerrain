<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig');
    }




    #[Route('/contact/submit', name: 'contact_submit')]

    public function submit(Request $request)
    {
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $message = $request->request->get('message');

        $to = 'your-email@example.com';
        $subject = 'New contact form submission';
        $body = "Name: $name\n\nEmail: $email\n\nMessage:\n$message";

        $headers = array(
            'From' => $email,
            'Reply-To' => $email,
        );

        // Send the email using the PHP mail() function
        mail($to, $subject, $body, $headers);

        // Redirect back to the contact form page
        return $this->redirectToRoute('contact');
    }
}
