<?php

namespace App\Repository;

use App\Entity\PageModule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PageModule|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageModule|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageModule[]    findAll()
 * @method PageModule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageModuleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PageModule::class);
    }

    public function getfindAllQueryBuilder()
    {
        return $this
            ->createQueryBuilder('p')
            ->orderBy('p.id','ASC');

    }
    // /**
    //  * @return PageModule[] Returns an array of PageModule objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PageModule
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
