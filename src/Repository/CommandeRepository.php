<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
/**
 * @extends ServiceEntityRepository<Commande>
 *
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
{
    parent::__construct($registry, Commande::class);
}

public function findAllWithProducts()
{
    return $this->createQueryBuilder('c')
        ->addSelect('a') // Select the associated product (Article)
        ->leftJoin('c.article', 'a')
        ->getQuery()
        ->getResult();
}
    
public function getMonthlyEarnings($month, $year)
{
    $rsm = new ResultSetMappingBuilder($this->getEntityManager());
    $rsm->addScalarResult('monthlyEarnings', 'monthlyEarnings');

    $query = $this->getEntityManager()
        ->createNativeQuery('
            SELECT SUM(total_price) as monthlyEarnings
            FROM commande
            WHERE MONTH(date_commande) = :month
            AND YEAR(date_commande) = :year
        ', $rsm)
        ->setParameter('month', $month)
        ->setParameter('year', $year);

    return $query->getSingleScalarResult();
}
//    /**
//     * @return Commande[] Returns an array of Commande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Commande
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
