<?php

namespace App\Repository;

use App\Entity\TypeParameters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeParameters|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeParameters|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeParameters[]    findAll()
 * @method TypeParameters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeParametersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeParameters::class);
    }

//    /**
//     * @return TypeParameters[] Returns an array of TypeParameters objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeParameters
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
