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

    public function searchCategory($category)
    {
        return $this->createQueryBuilder('Produit')
                    ->andWhere('Produit.category LIKE :cate')
                    ->setParameter('cate','%'.$category.'%')
                    ->distinct()
                    ->getQuery()
                    ->execute();

    }

    public function searchProduit($prod)
    {
        $searchProduit = $this->createQueryBuilder('p');
        return $searchProduit 
                    ->where('p.category LIKE :cate')
                    ->setParameter('cate','%'.$prod.'%')
                    ->orWhere('p.matiere LIKE :matiere')
                    ->setParameter('matiere','%'.$prod.'%')
                    ->orWhere('p.type LIKE :type')
                    ->setParameter('type','%'.$prod.'%')
                    ->getQuery()
                    ->execute();
        
    }

    /**
     * Récupère les produits en lien avec une recherche
     * @return Produit[]
     */

    public function findProduct(): array
    {
        return $this->findAll();
    }


    public function distinctCategories($categ){
        $searchCategory =  $this->createQueryBuilder('cc');
        return $searchCategory 
                        ->select('DISTINCT cc.category')
                        ->where('cc.category LIKE :cate')
                        ->setParameter('cate', '%'.$categ.'%')
                        ->getQuery()
                        ->getResult()
                        
        ;
    }

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
