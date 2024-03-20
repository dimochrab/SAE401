<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModifyProfileController extends AbstractController
{
    #[Route('/modify/profile', name: 'app_modify_profile')]
    public function index(): Response
    {
        return $this->render('modify_profile/index.html.twig', [
            'controller_name' => 'ModifyProfileController',
        ]);
    }
}
