<?php

namespace App\Repository;

use App\Entity\ChoixMedecin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChoixMedecin|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChoixMedecin|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChoixMedecin[]    findAll()
 * @method ChoixMedecin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChoixMedecinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChoixMedecin::class);
    }

    // /**
    //  * @return ChoixMedecin[] Returns an array of ChoixMedecin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChoixMedecin
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
