<?php

namespace App\Repository;

use App\Entity\Modeles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Modeles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Modeles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Modeles[]    findAll()
 * @method Modeles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Modeles::class);
    }

    /**
     * @return Query
     */
    public function  findAllQuery() : Query
    {
        return $this->createQueryBuilder('m')
            ->getQuery();
    }
//    /**
//     * @return Modeles[] Returns an array of Modeles objects
//     */
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
    public function findOneBySomeField($value): ?Modeles
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
