<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PublicationRepository;
use Symfony\Component\Routing\Attribute\Route;
use app\Entity\Publication;
use Symfony\Bundle\SecurityBundle\Security;

class HomeController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    #[Route('/home', name: 'app_home')]
    public function index(PublicationRepository $publicationRepository): Response
    {
        $publications = $publicationRepository->findBy([], ['DateTime' => 'DESC']);
        $user = $this->getUser();
        
        foreach ($publications as $publication) {
            $filename = $publication->getPostContent();
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                $publication->fileType = 'image';
            } elseif (in_array(strtolower($extension), ['mp4', 'avi', 'mov'])) {
                $publication->fileType = 'video';
            } else {
                $publication->fileType = 'unknown';
            }
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'publications' => $publications,
        ]);
    }
    
}