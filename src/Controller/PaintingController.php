<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PaintingRepository;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class PaintingController extends AbstractController
{
    #[Route('/tableau/{slug}', name: 'app_tableau_details')]
    public function details(
        string $slug, 
        PaintingRepository $repository,
        CommentRepository $commentRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response 

    {   
        // recuperation du tableau
        $painting = $repository->findOneBy(['slug' => $slug]);
        if (!$painting) {
            throw $this->createNotFoundException('tableau introuvable');
        }
        if (!$painting->isVisible() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createNotFoundException('Ce tableau n\'est pas disponible');
        }

        // recupeartion des commentaires du tableau
        $comments = $commentRepository->findBy(
            ['painting' => $painting],
            ['createdAt' => 'DESC']
        );

        // moyenne de la note
        $moyenneRating = $commentRepository->getMoyenneRating($painting);

        // formulaire commentaire + note 
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        // traitement formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->getuser()) {
                $this->addFlash('error', 'Vous devez être connecté pour noter ou commenter');
            } else {
                $existComment = $commentRepository->findOneBy([
                    'user' => $this->getUser(),
                    'painting' => $painting
                ]);

                if ($existComment) {
                    $this->addFlash('error', 'Vous avez déjà donné votre avis sur cette ouevre');
                } else {
                    $comment->setUser($this->getUser());
                    $comment->setPainting($painting);
                    $comment->setCreatedAt(new \DateTimeImmutable());

                    $entityManager->persist($comment);
                    $entityManager->flush();

                    $this->addFlash('success', 'votre avis a été publié!');
                }

                return $this->redirectToRoute('app_tableau_details', ['slug' => $slug]);
            }
        }

        // afficher la page
        return $this->render('pages/details.html.twig', [
            'painting' => $painting,
            'comments' => $comments,
            'commentForm' => $form,
            'moyenneRating' => $moyenneRating,
        ]);
    }
}
