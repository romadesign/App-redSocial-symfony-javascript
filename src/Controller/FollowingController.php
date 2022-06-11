<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FollowingController extends AbstractController
{
    /**
     * @Route("/follow", name="follow", methods={"POST"})
     */
      public function follow( Request $request): Response
    {
        return new Response('following');
    }

    /**
     * @Route("/unfollow", name="unfollow", methods={"POST"})
     */
    public function unfollow(Request $request): Response
    {
      return new Response('Un following');
    }
}
