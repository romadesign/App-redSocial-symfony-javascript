<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\CategoryType;


class CategoryController extends AbstractController
{
    private $category;
    private $session;
    public function __construct()
    {
      $this->category = new Category();
      $this->session = new Session();
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $categories = $entityManager->getRepository(Category::class)->findAll();
        return $this->render('category/index.html.twig', [
            'title' => 'Categorias',
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/categories_add", name="categories_add")
     */
    public function add( Request $request, ManagerRegistry $doctrine): Response
    {
      $entityManager = $doctrine->getManager();

      $form = $this->createForm(CategoryType::class, $this->category);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()){
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($this->category);

        // actually executes the queries (i.e. the INSERT query)
        $flush = $entityManager->flush();
        if($flush === null){
          $msg = "La categoria ha sido ingresada con exito.";
        }else{
          $msg = "La categoria no ha podido ser ingresada.";
        }
        $this->session->getFlashBag()->add('msg', $msg);
        return $this->redirectToRoute('categories');
      }

      return $this->render('category/add.html.twig', [
        'title' => 'Add Categorias',
        'form' => $form->createView(),
      ]);
    }

    /**
     * @Route("/categorie_id/{id}", name="categorie_id")
     */
    public function edit($id, Request $request, ManagerRegistry $doctrine): Response
    {
      $entityManager = $doctrine->getManager();
      $this->category = $entityManager->getRepository(Category::class)->find($id);
      $form = $this->createForm(CategoryType::class, $this->category);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($this->category);
        $flush = $entityManager->flush();
        if($flush === null){
          $msg = "La categoria ha sido editada con exito.";
        }else{
          $msg = "La categoria no ha podido ser editar.";
        }
        $this->session->getFlashBag()->add('msg', $msg);
        return $this->redirectToRoute('categories');
      }
      return $this->render('category/edit.html.twig', [
        'title' => 'Editar categoria',
        'id' => $id,
        'form' => $form->createView(),
      ]);
    }


    /**
     * @Route("/categorie_delete/{id}", name="categorie_delete")
     */
    public function delete($id, Request $request, ManagerRegistry $doctrine): Response
    {
      $entityManager = $doctrine->getManager();
      $this->category = $entityManager->getRepository(Category::class)->find($id);
      $entityManager->remove($this->category);
      $flush = $entityManager->flush();
      if($flush === null){
        $msg = "La categoria" . '""' . $this->category->getName(). '""' . "ha sido eliminada con exito.";
      }else{
        $msg = "La categoria no ha podido eliminar.";
      }
      $this->session->getFlashBag()->add('msg', $msg);
      return $this->redirectToRoute('categories');
    }


    /**
     * @Route("/postPorCategorias/{id}", name="postPorCategorias")
     */
    public function categoriesPost($id,ManagerRegistry $doctrine): Response
    {
      $entityManager = $doctrine->getManager();
      $categorie = $entityManager->getRepository(Category::class)->find($id);
      $posts = $categorie->getPosts();
      return $this->render('category/categories_post.html.twig', [
        'title' => $categorie->getName(),
        'posts' => $posts,
      ]);
    }
}
