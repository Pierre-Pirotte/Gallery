<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Painting;
use App\Form\PaintingType;
use App\Repository\PaintingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/paintings', name: 'admin_painting_')]
#[IsGranted('ROLE_ADMIN')]
class PaintingAdminController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(PaintingRepository $paintingRepository): Response
    {
        $paintings = $paintingRepository->findAll();
        return $this->render('admin/painting/index.html.twig', [
            'paintings' => $paintings,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function newPainting(Request $request, EntityManagerInterface $em, SluggerInterface $slugger):Response
    {
        // nouveau tableau
        $painting = new Painting();

        // créer formulaire
        $form = $this->createForm(PaintingType::class, $painting);

        // soumission
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // generation du slug
            $slug = $slugger->slug($painting->getTitle())->lower();
            $painting->setSlug($slug);
        
            // sauvegardea en base 
            $em->persist($painting);
            $em->flush();

            // message de succès
            $this->addFlash('success', 'Le tableau "'.$painting->getTitle(). '"a été ajouté avec succès!');

            // redirection 
            return $this->redirectToRoute('admin_painting_index');
        }

        return $this->render('admin/painting/newPainting.html.twig', ['form' => $form->createView()]);

        
    }
}

