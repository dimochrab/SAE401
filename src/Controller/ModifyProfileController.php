<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ModifyProfileController extends AbstractController
{
    #[Route('/modify/profile', name: 'app_modify_profile')]
    public function modifier(Request $request, UserInterface $user, EntityManagerInterface $entityManager): Response
    {
        // Assurez-vous que $user est bien une instance de votre entité Utilisateur
        // ou récupérez l'utilisateur d'une autre manière si nécessaire

        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Pas besoin de faire appel à $this->getDoctrine()->getManager();
            $entityManager->flush();

            // Redirigez vers la page de profil ou ailleurs après la mise à jour
            return $this->redirectToRoute('app_utilisateur');
        }

        return $this->render('modify_profile/index.html.twig', [
            'utilisateurForm' => $form->createView(),
        ]);
    }
}
