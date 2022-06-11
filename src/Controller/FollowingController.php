<?php

namespace App\Controller;

use App\Entity\Following;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class FollowingController extends AbstractController
{
    /**
     * @Route("/follow", name="follow", methods={"POST"})
     */
      public function follow(ManagerRegistry $doctrine, Request $request): Response
    {

        $user = $this->getUser();
        $followed_id = $request->get('followed');


        $entityManager = $doctrine->getManager();
        $user_repository = $entityManager->getRepository(User::class);

        $followed = $user_repository->find($followed_id);

        $following = new Following;
        $following->setUser($user);
        $following->setFollowed($followed);

        $entityManager->persist($following);
        $flush = $entityManager->flush();

        if($flush === null){
          $msg = 'No you are following this user';
        }else{
          $msg = 'Request failed';
        }

        return new Response($msg);
    }

    /**
     * @Route("/unfollow", name="unfollow", methods={"POST"})
     */
    public function unfollow(Request $request): Response
    {
      return new Response('Un following');
    }
}
