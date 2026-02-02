<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\PaintingRepository;
use App\Repository\TechnicalRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class PagesController extends AbstractController
{
    #[Route('/gallery', name: 'app_gallery')]
    public function gallery(
        PaintingRepository $repository,
        TechnicalRepository $technicalRepository,
        CategoryRepository $categoryRepository,
        Request $request
    ): Response
    {

        // recuperation des param get de l'url pour technical et category
        $technicalId = $request->query->get('technical');
        $categoryId = $request->query->get('category');

        // variable pour la recherche
        $search = $request->query->get('search');

        // tableau de critères
        $tri = [];

        // cache les tableaux masqués pour les non-admins
        if (!$this->isGranted('ROLE_ADMIN')) {
            $tri['isVisible'] = true;
        }

        if ($categoryId) {
            $tri['category'] = $categoryId;
        }

        if ($technicalId) {
            $tri['technical'] = $technicalId;
        }

        $paintings = $repository->searchPaintings($search, $tri);

        return $this->render('pages/gallery.html.twig', [
            'paintings' => $paintings, 
            'technicals' => $technicalRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);

    }


    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('pages/about.html.twig');
    }

    #[Route('/team', name: 'app_team')]
    public function team(): Response
    {
        return $this->render('pages/team.html.twig');
    }
}
 