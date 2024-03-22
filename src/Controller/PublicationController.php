<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PublicationController extends AbstractController
{
    #[Route('/publication', name: 'app_publication')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $Publication = new Publication();
        $form = $this->createForm(PublicationType::class, $Publication);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($Publication);
            $entityManager->flush();

            $this->addFlash('success', 'Pub ajoutée avec succès.');

            return $this->redirectToRoute('app_publication');
        }
        return $this->render('publication/index.html.twig', [
            'controller_name' => 'PublicationController',
            'form' => $form->createView(),
        ]);
    }
}
