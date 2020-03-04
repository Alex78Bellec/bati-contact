<?php

namespace App\Repository;
use App\Entity\Distributeur;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function searchProduit($prod)
    {
        return $this->createQueryBuilder('Produit')
                    ->andWhere('Produit.category LIKE :cate')
                    ->setParameter('cate','%'.$prod.'%')
                    ->getQuery()
                    ->execute();

    }

/*     public function findByDistrib($distrib)
    {
        return $this->createQueryBuilder('Produit')
                    ->andWhere('(Produit.distrib) = :distrib')
                    ->setParameter('distrib','%'.$distrib.'%')
                    ->getQuery()
                    ->execute();

    }
 */
/*     public function myFindByDistrib($distrib)
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p.distrib')
            ->join ('p.distrib','d','WITH','d = :d')
            ->where('d.id = :id');

            $qb->setParameter('d', $distrib);
        
        $query = $qb->getQuery();
        $results = $query->getResult();
        return $results; 
    }  */

    // /**
    //  * @return Produit[] Returns an array of Produit objects
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
    public function findOneBySomeField($value): ?Produit
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
