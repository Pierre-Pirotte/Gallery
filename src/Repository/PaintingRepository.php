<?php

namespace App\Repository;

use App\Entity\Painting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Painting>
 */
class PaintingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Painting::class);
    }

    // fonction de recherche

    public function searchPaintings(?string $search, array $tri): array
    {
        $result = $this->createQueryBuilder('p');

        // Liste blanche des colonnes autorisées
        $allowedColumns = ['isVisible', 'category', 'technical'];

        foreach ($tri as $key => $value) {
            if (in_array($key, $allowedColumns, true)) {
                $result->andWhere("p.$key = :$key")
                        ->setParameter($key, $value);
            }
        }
        
        if ($search) {
            $result->andWhere('p.title LIKE :search OR p.author LIKE :search')
                    ->setParameter('search', '%' . $search . '%');
        }
        return $result->getQuery()->getResult();
    }

    //    /**
    //     * @return Painting[] Returns an array of Painting objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Painting
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
