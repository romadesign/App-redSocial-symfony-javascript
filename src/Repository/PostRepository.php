<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

//paginate
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{

  public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
//        parent::__construct($registry, User::class);
    }

    public function add(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Post[] Returns an array of Post objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

      //paginate post
      public function getPostPaginator($limit=1, $page=1): Paginator
      {
          $query = $this->createQueryBuilder('t')
              ->andWhere('t.status = :status')
              ->setParameter('status', 'public')
              ->setFirstResult($limit * ($page -1))
              ->setMaxResults($limit)
              ->orderBy('t.id', 'DESC')
              ->getQuery()
          ;

          return new Paginator($query);
      }

      public function moveImgToDirectory($file): string
      {
        $extension = $file->guessExtension();
        $file_name = md5(uniqid('', true)).'.'.$extension;
        $file->move("img", $file_name);
        return $file_name;
      }

      public function savePostTags($form_tag = null, $post = null)
      {
        $entityManager = $this->getEntityManager();
        $tags_array = explode(',', $form_tag);
        foreach ($tags_array as $tag) {
          $tagEntity = new Tag();
          $tagEntity->setName($tag);
          $tagEntity->setDescription($tag);
          $tagEntity->addPost($post);

          $entityManager->persist($post);
          $entityManager->persist($tagEntity);
          $flush = $entityManager->flush();
        }
        return $flush;
      }

      public function getSearch($palabra){
        $query = $this->createQueryBuilder('t')
          ->where('t.title LIKE :searchterm')
          ->orWhere('t.text LIKE :searchterm')
          ->setParameter('searchterm','%'.$palabra.'%')
          ->orderBy('t.id', 'DESC')
          ->getQuery()
          ->getResult();

        return $query;
      }



}
