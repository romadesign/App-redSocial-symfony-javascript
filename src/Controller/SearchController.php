<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchType;
use App\Entity\Post;


class SearchController extends AbstractController
{

    public function searchBar(Request $request){
        $form = $this->createForm(SearchType::class, null);
        return $this->render(
          'search/searchForm.html.twig',[
            'form' => $form->createView()
          ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request, ManagerRegistry $doctrine ): Response
    {
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(SearchType::class, null);
        $form->handleRequest($request);
        $palabra = null;
        $results = null;
        $totalResults = '';

        if( $form->isSubmitted()){
            $palabra = $form->get('search')->getData();
            $palabra = htmlspecialchars(addslashes(trim($palabra)));

            if ($palabra == null | $palabra == '' | empty($palabra)){
                return $this->redirectToRoute('index');
            }else{
              $post_repository = $entityManager->getRepository(Post::class);
              $results = $post_repository->getSearch($palabra);
              $totalResults = count($results);
            }
        }
        return $this->render('search/index.html.twig', [
            'palabra' => $palabra,
            'results' => $results,
            'totalResult' => $totalResults,
        ]);
    }
}
