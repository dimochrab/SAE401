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
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $publication->setDateTime(new \DateTime());

            $user = $this->getUser(); 
            $publication->setUserID($user);

            $file = $form->get('file')->getData();

            if ($file) {
                // Obtenir l'extension du fichier
                $fileExtension = $file->guessExtension();
                // Construire le nouveau nom de fichier en utilisant l'ID de l'utilisateur et l'extension du fichier
                $newFilename = "PublicationUploads_" . $user->getId() . "." . $fileExtension;
        
                // Déplacer le fichier dans le répertoire où vos fichiers sont stockés
                try {
                    $file->move(
                        $this->getParameter('uploads_directory'), // Assurez-vous que ce paramètre est bien configuré
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer l'exception si quelque chose se passe mal pendant l'upload du fichier
                }
        
                // Mettre à jour l'entité avec le chemin/nom du fichier
                $publication->setPostContent($newFilename);
            }

            $entityManager->persist($publication);
            $entityManager->flush();

            $this->addFlash('success', 'Publication ajoutée avec succès.');
            return $this->redirectToRoute('app_publication');
        }

        return $this->render('publication/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/publication/edit/{id}', name: 'publication_edit')]
    public function edit(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Publication modifiée avec succès.');

            return $this->redirectToRoute('app_utilisateur');
        }

        return $this->render('publication/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/publication/delete/{id}', name: 'publication_delete')]
    public function delete(Publication $publication, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($publication);
        $entityManager->flush();
        $this->addFlash('success', 'Publication supprimée avec succès.');

        return $this->redirectToRoute('app_utilisateur');
    }

    #[Route('/like/publication/{id}', name: 'like_publication', methods: ['POST'])]
    public function likePublication($id, Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);
        $publication = $em->getRepository(Publication::class)->find($id);
    
        if (!$publication) {
            return $this->json(['error' => 'Publication non trouvée'], 404);
        }
    
        if ($data['like']) {
            // Logique pour "liker" : incrémenter les likes
            $publication->setLikesCount($publication->getLikesCount() + 1);
        } else {
            // Logique pour "disliker" : décrémenter les likes
            $publication->setLikesCount($publication->getLikesCount() - 1);
        }
    
        $em->flush();
    
        // Ici, vous pouvez également ajouter une logique pour notifier l'utilisateur
    
        return $this->json(['message' => 'Succès']);
    }
}
