<?php

namespace App\Controller;

use App\Repository\PaintingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PagesController extends AbstractController
{
    #[Route('/gallery', name: 'app_gallery')]
    public function gallery(PaintingRepository $repository): Response
    {
        // cache les tableaux masqués pour les non-admins
        if ($this->isGranted('ROLE_ADMIN')) {
            $paintings = $repository->findAll();
        } else {
            $paintings = $repository->findBy(['isVisible' => true]);
        }
        return $this->render('pages/gallery.html.twig', [
            'paintings' => $paintings
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
 