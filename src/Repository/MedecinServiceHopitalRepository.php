<?php

namespace App\Repository;

use App\Entity\MedecinServiceHopital;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MedecinServiceHopital|null find($id, $lockMode = null, $lockVersion = null)
 * @method MedecinServiceHopital|null findOneBy(array $criteria, array $orderBy = null)
 * @method MedecinServiceHopital[]    findAll()
 * @method MedecinServiceHopital[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedecinServiceHopitalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MedecinServiceHopital::class);
    }

    // /**
    //  * @return MedecinServiceHopital[] Returns an array of MedecinServiceHopital objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MedecinServiceHopital
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
