<?php

namespace App\Repository;

use App\Entity\Product;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\AST\Join;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
    public function FindProduct()
    {
         $qb =  $this->createQueryBuilder('p');
         $qb
            //->innerJoin('App\Entity\Category','c',Join::JOIN_TYPE_INNER,'c.id = p.category')
            ->select('p.id,p.code_product,p.name_product,p.description_product,p.brand,p.price,c.name_category')
            ->innerJoin('App\Entity\Category','c',\Doctrine\ORM\Query\Expr\Join::WITH,'c.id = p.category')
            ->where('c.active=1');
        return $qb->getQuery()->getResult();
        /*return $this->getEntityManager()->createQuery('SELECT p.id, p.code_product,p.name_product,p.description_product,p.brand,p.price FROM App:Product p, App\Entity\Category c
         where c.active=1 and c.id = p.category');*/
    }
    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
