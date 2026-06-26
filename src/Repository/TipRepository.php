<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Tip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tip>
 */
class TipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tip::class);
    }

    /**
     * @return Tip[]
     */
    public function findApplicableForMonth(int $month): array
    {
        $rsm = $this->createResultSetMappingBuilder('t');

        $sql = 'SELECT ' . $rsm->generateSelectClause() . ' FROM tip t WHERE t.months @> :month';

        return $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->setParameter('month', json_encode([$month]))
            ->getResult();
    }

    //    /**
    //     * @return Tip[] Returns an array of Tip objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Tip
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
