<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;


class TagController extends AbstractController
{
    private $tag;
    private $session;
    public function __construct()
    {
      $this->tag = new Tag();
      $this->session = new Session();
    }

    /**
     * @Route("/tags", name="tags")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $tags = $entityManager->getRepository(Tag::class)->findAll();
        return $this->render('tag/index.html.twig', [
            'title' => 'Tags',
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/tags_add", name="tags_add")
     */
    public function add( Request $request, ManagerRegistry $doctrine): Response
    {
      $entityManager = $doctrine->getManager();

      $form = $this->createForm(TagType::class, $this->tag);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()){
        $entityManager->persist($this->tag);
        $flush = $entityManager->flush();
        if($flush === null){
          $msg = "El tag ha sido ingresada con exito.";
        }else{
          $msg = "El tag no ha podido ser ingresado.";
        }
        $this->session->getFlashBag()->add('msg', $msg);
        return $this->redirectToRoute('tags');
      }

      return $this->render('tag/add.html.twig', [
        'title' => 'Agregar Tag',
        'form' => $form->createView(),
      ]);
    }


    /**
     * @Route("/tag_id/{id}", name="tag_id")
     */
    public function edit($id, Request $request, ManagerRegistry $doctrine): Response
    {
      $entityManager = $doctrine->getManager();
      $this->tag = $entityManager->getRepository(Tag::class)->find($id);
      $form = $this->createForm(TagType::class, $this->tag);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($this->tag);
        $flush = $entityManager->flush();
        if($flush === null){
          $msg = "El tag ha sido editado con exito.";
        }else{
          $msg = "El tag no ha podido editar.";
        }
        $this->session->getFlashBag()->add('msg', $msg);
        return $this->redirectToRoute('tags');
      }
      return $this->render('tag/edit.html.twig', [
        'title' => 'Editar tag',
        'id' => $id,
        'form' => $form->createView(),
      ]);
    }


    /**
     * @Route("/tag_delete/{id}", name="tag_delete")
     */
    public function delete($id, Request $request, ManagerRegistry $doctrine): Response
    {
      $entityManager = $doctrine->getManager();
      $this->tag = $entityManager->getRepository(Tag::class)->find($id);
      $entityManager->remove($this->tag);
      $flush = $entityManager->flush();
      if($flush === null){
        $msg = "El tag" . '""' . $this->tag->getName(). '""' . "ha sido eliminada con exito.";
      }else{
        $msg = "El tag no ha podido ser eliminado.";
      }
      $this->session->getFlashBag()->add('msg', $msg);
      return $this->redirectToRoute('tags');
    }
}
