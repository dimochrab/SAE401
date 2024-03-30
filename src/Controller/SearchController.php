<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PublicationRepository;
use App\Repository\UtilisateurRepository;


class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function search(Request $request, PublicationRepository $publicationRepo, UtilisateurRepository $userRepo)
    {
        $query = $request->query->get('query');

        if ($query) {
            $publications = $publicationRepo->findByQuery($query);
            $users = $userRepo->findByQuery($query);
        } else {
            $publications = [];
            $users = [];
        }
        
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

        return $this->render('search/index.html.twig', [
            'publications' => $publications,
            'users' => $users,
            'query' => $query
        ]);
    }
}
