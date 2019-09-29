<?php

namespace App\Repository;

use App\Entity\UserInscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserInscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserInscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserInscription[]    findAll()
 * @method UserInscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserInscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserInscription::class);
    }

    // /**
    //  * @return UserInscription[] Returns an array of UserInscription objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserInscription
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
