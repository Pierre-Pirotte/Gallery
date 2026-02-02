<?php

namespace App\Controller;

use App\Repository\PaintingRepository;
// CommentRepository pour utiliser la méthode getMoyenneRating pour le tableau le mieux noté
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PaintingRepository $repository, CommentRepository $commentRepository): Response
    {
        // Récupère les tableaux visibles pour le carousel (tous pour les admins)
        if ($this->isGranted('ROLE_ADMIN')) {
            $featuredPaintings = $repository->findAll();
        } else {
            $featuredPaintings = $repository->findBy(['isVisible' => true]);
        }
        
        // Pour sélectionner le tableau avec la meilleure note
        $topRatingPainting = null;
        $bestRating = 0;

        foreach ($featuredPaintings as $painting) {
            $moyenne = $commentRepository->getMoyenneRating($painting);

            if ($moyenne !== null && $moyenne > $bestRating) {
                
                $bestRating = $moyenne;
                $topRatingPainting = $painting;
               
            }
        }
        
        

        return $this->render('home/index.html.twig', [
            'featuredPaintings' => $featuredPaintings,
            'topRatingPainting' => $topRatingPainting,
            'bestRating' => $bestRating,
        ]);
    }

}
