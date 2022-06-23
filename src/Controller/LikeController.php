<?php

namespace App\Controller;

use App\Entity\Likes;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
  /**
   * @Route("/like", name="like", methods={"POST"})
   */
  public function index(ManagerRegistry $doctrine, Request $request): Response
  {
    $user = $this->getUser();
    $publication_id = $request->get('publication');

    $entityManager = $doctrine->getManager();
    $publication_repository = $entityManager->getRepository(Post::class);

    $publication = $publication_repository->find($publication_id);

    $like = new Likes();
    $like->setUser($user);
    $like->setPublication($publication);

    $entityManager->persist($like);
    $flush = $entityManager->flush();

    if ($flush === null) {
      $msg = 'No you are like this publication';
    } else {
      $msg = 'Like action failed, please try later.';
    }

    return new Response($msg);
  }
}
