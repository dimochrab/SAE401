<?php

// src/Controller/ContactController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactFormType;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $emailUser = $user ? $user->getEmail() : 'fallbackemail@example.com'; // Utilisez un e-mail par défaut si nécessaire

            $email = (new Email())
                ->from($emailUser)
                ->to('admin@example.com') // Remplacez par votre e-mail réel pour la production
                ->subject('Message du formulaire de contact')
                ->text('Envoyé par : '.$emailUser."\n\n".$contactFormData['message'])
                ->html('<p>Envoyé par : '.$emailUser.'</p><p>'.$contactFormData['message'].'</p>');

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a été envoyé.');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}
