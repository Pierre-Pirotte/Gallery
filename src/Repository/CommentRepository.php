<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Painting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function getMoyenneRating(Painting $painting): ?float
    {
        // calcule la note moyenne d'un tableau
        // c = alias pour la table comment
        $result = $this->createQueryBuilder('c')
            ->select('AVG(c.rating) as moyenne')
            ->where('c.painting = :painting')
            // exclu les commentaires sans notes, calcul que sur les rating existants
            ->andWhere('c.rating IS NOT NULL')
            ->setParameter('painting', $painting)
            ->getQuery()
            // prend une seule ligne de résultat et une seule colonne (nombre)
            ->getSingleScalarResult();
        
            // fonction round pour arrondir à une décimale
        return $result ? round($result, 1) : null;
    }
    //    /**
    //     * @return Comment[] Returns an array of Comment objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Comment
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
