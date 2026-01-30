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
    // méthode d'affichage
    #[Route('', name: 'index')]
    public function index(PaintingRepository $paintingRepository): Response
    {
        $paintings = $paintingRepository->findAll();
        return $this->render('admin/painting/index.html.twig', [
            'paintings' => $paintings,
        ]);
    }

    // méthode d'ajout
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

        return $this->render('admin/painting/newPainting.html.twig', [
            'form' => $form,
        ]);

    }

    // méthode pour la visibilité on/off
    #[Route('/{id}/toggle', name: 'toggle', methods: ['GET'])]
    public function toggleVisibility(Painting $painting, EntityManagerInterface $em):Response 
    {
        $painting->setIsVisible(!$painting->isVisible());
        $em->flush();

        $status = $painting->isVisible() ? 'visible' : 'masqué';
        $this->addFlash('success', 'Le tableau "'. $painting->getTitle().'" est maintenant ' .$status. '.');

        return $this->redirectToRoute('admin_painting_index');
    }

    // méthode de modification
    #[Route('/{id}/edit', name: 'edit')]
    public function edit(Painting $painting, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
     // créer formulaire
        $form = $this->createForm(PaintingType::class, $painting, ['is_edit' => true]);

        // soumission
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // generation du slug
            $slug = $slugger->slug($painting->getTitle())->lower();
            $painting->setSlug($slug);
            
            // Mise à jour du timestamp pour VichUploader si l'image a changé
            if ($painting->getImageFile() !== null) {
                $painting->setUpdatedAt(new \DateTimeImmutable());
            }
        
            // sauvegarde en base, pas besoin de persist pour modification
            $em->flush();

            // message de succès
            $this->addFlash('success', 'Le tableau "'.$painting->getTitle(). '"a été mis à jour avec succès!');

            // redirection 
            return $this->redirectToRoute('admin_painting_index');
        }

        return $this->render('admin/painting/editPainting.html.twig', [
            'form' => $form,
            'painting' => $painting,
        ]);   
    }

    // méthode de suppression -> 'POST' empeche les suppressions accidentelles via URL
    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(Painting $painting, Request $request, EntityManagerInterface $em): Response
    {
        // token CSRF
        if ($this->isCsrfTokenValid('delete'.$painting->getId(), $request->request->get('_token'))) {
            $title = $painting->getTitle();
            $em->remove($painting);
            $em->flush();
            $this->addFlash('success', 'Le tableau "'.$title. '"a été supprimé avec succès!');
        
        } else {
            $this->addFlash('error', 'token CSRF invalide.');
        }
        return $this->redirectToRoute('admin_painting_index');
    }
}

