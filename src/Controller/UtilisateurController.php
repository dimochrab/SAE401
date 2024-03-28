<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function profil(): Response
    {
        $utilisateur = $this->getUser();
        
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }
    
        return $this->render('utilisateur/index.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }
    
}