<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
use Symfony\component\Security\Http\Attribute\IsGranted;

#[Route('/admin/users', name: 'admin_user_')]
// restreint l'accès aux admins uniquement
#[IsGranted('ROLE_ADMIN')]

final class UserAdminController extends AbstractController
{
    // méthode d'afficahge
    #[Route('', name: 'index')]
    public function index(UserRepository $userRepository): Response
    {
        // récupere tous les utilisateurs avec le rôle user uniquement
        $users = $userRepository->createQueryBuilder('u')
        ->orderBy('u.createdAt', 'DESC')
        ->where('u.roles NOT LIKE :role')
        ->setParameter('role', '%"ROLE_ADMIN"%')
        ->getQuery()
        ->getResult();

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
        ]);
    }
}
