<?php

namespace App\Controller;

use App\Repository\PaintingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PaintingRepository $repository): Response
    {
        // Récupère tous les tableaux pour le carousel
        $featuredPaintings = $repository->findAll();
        
        return $this->render('home/index.html.twig', [
            'featuredPaintings' => $featuredPaintings,
        ]);
    }
}
