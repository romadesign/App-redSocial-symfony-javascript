<?php

namespace App\Repository;

use App\Entity\Following;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DriverManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;

/**
 * @extends ServiceEntityRepository<Following>
 *
 * @method Following|null find($id, $lockMode = null, $lockVersion = null)
 * @method Following|null findOneBy(array $criteria, array $orderBy = null)
 * @method Following[]    findAll()
 * @method Following[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FollowingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Following::class);
    }

    public function add(Following $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function remove(Following $entity, bool $flush = false): void
    {
      $this->getEntityManager()->remove($entity);

      if ($flush) {
        $this->getEntityManager()->flush();
      }
    }

//    /**
//     * @return Following[] Returns an array of Following objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Following
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

      //Query select usuarios seguidos
      public function getFollowUser($id){
        $query = $this->createQueryBuilder('f' )
          ->andWhere('f.user = :id')
          ->setParameter('id', $id)
          ->getQuery()
          ->getResult();
        return $query;

      }

      //Query select usuarios seguidos
      public function delete($id){
        $query = $this->delete('f' )
          ->andWhere('f.id = :id')
          ->setParameter('id', $id)
          ->getQuery()
          ->getResult();

        dd($query);
        return $query;

      }

//
//$query = $this->createQueryBuilder('f' )
//->innerJoin('f.user', 'u', 'WITH', 'u.id = f. user')
//->andWhere('f.user = :id')
//->setParameter('id', $id)
//->getQuery()
//->getResult();
//return $query;
//

//
//  public function getFollowUser($id){
//    return $this->createQueryBuilder('follow')
//      ->select('follow')
//      ->innerJoin('App\Entity\User', 'user', Expr\Join::WITH, 'user.id = follow.user')
//      ->andWhere('follow.user = :id')
//      ->setParameter('id', $id)
//      ->getQuery()
//      ->getResult();
//  }


//  public function getFollowUser($id){
//    return $this->createQueryBuilder('f')
//      ->andWhere('f.user = :id')
//      ->setParameter('id', $id)
//      ->orderBy('f.id', 'ASC')
//      ->getQuery()
//      ->getResult();
//  }
}
