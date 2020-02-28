<?php

namespace App\Repository;

use App\Entity\Distributeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Distributeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Distributeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Distributeur[]    findAll()
 * @method Distributeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistributeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Distributeur::class);
    }


/*     public function findByDistrib($produit)
    {
        $qb = $this->createQueryBuilder('distributeur')
            ->leftJoin ('distributeur.produits','p')
            ->where('p.distrib = :distrib')
            ->setParameter('distrib', $produit);
        
        $query = $qb->getQuery();
        $results = $query->getResult();
        return $results;
    } */
    

    // /**
    //  * @return Distributeur[] Returns an array of Distributeur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Distributeur
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
