<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/admin/comment', name: 'admin_comment_')]
// restreint l'accès aux admins uniquement
#[IsGranted('ROLE_ADMIN')]

class CommentAdminController extends AbstractController
{
    // méthode d'affichage
    #[Route('', name: 'index')]
    public function index(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findBy([], ['createdAt' => 'DESC']);
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    // méthode pour la visibilité on/off
    #[Route('/{id}/toggle', name: 'toggle', methods: ['GET'])]
    public function toggleVisibility(Comment $comment, EntityManagerInterface $em):Response 
    {
        // bascule la visibilité
        $comment->setIsVisible(!$comment->isVisible());
        $em->flush();

        $status = $comment->isVisible() ? 'visible' : 'masqué';
        $this->addFlash('success', 'Le commentaire a été '.$status.'.');
        return $this->redirectToRoute('admin_comment_index');
    }
}