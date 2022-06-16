<?php

namespace App\Controller;

use App\Entity\Following;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;



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
       * @Route("/unfollow/{id}", name="unfollow")
       */
      public function unfollow($id, Request $request, ManagerRegistry $doctrine): Response
      {
        $entityManager = $doctrine->getManager();
        $followed = $entityManager->getRepository(Following::class)->find($id);

        $entityManager->remove($followed);
        $flush = $entityManager->flush();
        if($flush === null){
          $msg = 'No you are not following this user';
        }else{
          $msg = 'Request failed';
        }

        return new Response($msg);
      }

      /**
       * @Route("/getContacFollow", name="getContacFollow")
       */
      public function getContacFollow(ManagerRegistry $doctrine): Response
      {
        $id = $this->getUser()->getId();
        $follow = $doctrine->getManager()->getRepository(Following::class)->getFollowUser($id);
        $data = [];
        $idx = 0;
        foreach ($follow as $fo){
          $temp = [
            'id' => $fo->getId(),
            'followed_user_id' => $fo->getFollowed()->getId(),
            'followed_email' => $fo->getFollowed()->getEmail(),
            'followed_name' => $fo->getFollowed()->getName(),
            'followed_img' => $fo->getFollowed()->getImg(),
            'followed_subname' => $fo->getFollowed()->getSubname(),
            'followed' => $fo->getFollowed(),
          ];
          $data[$idx++] = $temp;
        }

        return new JsonResponse($data);
      }
}
