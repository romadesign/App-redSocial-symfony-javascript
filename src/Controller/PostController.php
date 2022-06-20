<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Category;
use App\Entity\Tag;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;


class PostController extends AbstractController
{
    private $post;
    private $session;
    public function __construct()
    {
      $this->post = new Post();
      $this->session = new Session();
    }


    /**
     * @Route("/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1}, name="index")
   */
    public function index($page=1, ManagerRegistry $doctrine): Response
    {
      $entityManager = $doctrine->getManager();
      //Paginate
      $articlesByPage = 1;
      $posts = $entityManager->getRepository(Post::class)->getPostPaginator($articlesByPage, $page);

      $categories = $entityManager->getRepository(Category::class)->findAll();
      $tags = $entityManager->getRepository(Tag::class)->findAll();
      $users = $entityManager->getRepository(User::class)->findAllUsers();

      //Paginate
      $totalPost = count($posts);
      $pageCount = ceil($totalPost / $articlesByPage);

      return $this->render('inicio/index.html.twig', [
        'title' => 'Publicaciones',
        'posts' => $posts,
        'categories' => $categories,
        'tags' => $tags,
        'users' => $users,
        'page' => $page,
        'totalPost' => $totalPost,
        'pageCount' => $pageCount,
      ]);
    }// fin function


    public function component(Request $request){
      $form = $this->createForm(PostType::class, null);
      return $this->render('post/componentPostForm.html.twig', [
        'form' => $form->createView(),
      ]);
    }


    /**
     * @Route("/post_add", name="post_add")
     */
    public function add(Request $request, ManagerRegistry $doctrine){
      $entityManager = $doctrine->getManager();
      $post_repository = $entityManager->getRepository(Post::class);
      $form = $this->createForm(PostType::class, $this->post);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()){
       //datos que vienen del formulario
        $form_title = $form->get('title')->getData();
        $form_text = $form->get('text')->getData();
        $form_image = $form->get('image')->getData();
        $form_status = $form->get('status')->getData();
        $form_categorie = $form->get('categoria')->getData();
        $form_tag = $form->get('tag')->getData();

        //datos ingresados por el controlador
        $user = $this->getUser();

        //setear los datos
        $this->post->setUser($user);
        $this->post->setTitle($form_title);
        $this->post->setText($form_text);
        $this->post->setDate(new \DateTime('now'));
        $this->post->setStatus($form_status);
        //$this->post->setCategoria($form_categorie);
        //$this->post->addTag($form_tag);

        //image
        $name_img = $post_repository->moveImgToDirectory($form_image);
        $this->post->setImage($name_img);

        if(!empty($form_tag)){
          $post_repository->savePostTags($form_tag, $this->post);
        }

        $entityManager->persist($this->post);
        $flush = $entityManager->flush();
        if($flush === null){
          $msg = "El post se agrego con exito.";
        }else{
          $msg = "El tag no ha podido ser eliminado.";
        }
        $this->session->getFlashBag()->add('msg', $msg);
//        return $this->redirectToRoute('index');
        return new Response("User POST is successfully uploaded.");
      }

//      return $this->render('inicio/index.html.twig', [
//        'title' => 'Agregar nuevo post',
//        //'form' => $form->createView(),
//      ]);
    }

    /**
     * @Route("/post_edit/{id}", name="post_edit")
     */
    public function edit($id, Request $request, ManagerRegistry $doctrine): Response
    {
      $entityManager = $doctrine->getManager();
      $this->post = $entityManager->getRepository(Post::class)->find($id);
      $tag_repo = $entityManager->getRepository(Tag::class);
      $categorie_repo = $entityManager->getRepository(Category::class);
      $post_repository = $entityManager->getRepository(Post::class);

        //capture userLogin $this->getUser()->getId()
      if ($this->post === null){
        return $this->redirectToRoute('index');
      }else{
        if($this->getUser()->getId() === $this->post->getUser()->getId()){
          $post_tags = null;
          foreach ($this->post->getTag() as $tag_post) {
            $r_tag = $tag_repo->find($tag_post->getId());
            $entityManager->remove($r_tag);
            $tags[] = $r_tag->getName();
            $post_tags = implode(',', $tags);
            $this->post->removeTag($tag_post);
            $entityManager->persist($this->post);
          }
          $form  = $this->createForm(PostType::class, $this->post);
          $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()){
            //datos que vienen del formulario
            $form_title = $form->get('title')->getData();
            $form_text = $form->get('text')->getData();
            $form_image = $form->get('image')->getData();
            $form_status = $form->get('status')->getData();
            $form_categorie = $form->get('categoria')->getData();
            $form_tag = $form->get('tag')->getData();

            //datos ingresados por el controlador
            $user = $this->getUser();

            //setear los datos
            $this->post->setUser($user);
            $this->post->setTitle($form_title);
            $this->post->setText($form_text);
            $this->post->setDate(new \DateTime('now'));
            $this->post->setStatus($form_status);
            //$this->post->setCategoria($form_categorie);
            //$this->post->addTag($form_tag);

            //image
            if ($form_image != null){
              $name_img = $post_repository->moveImgToDirectory($form_image);
              $this->post->setImage($name_img);
            }

            if(!empty($form_tag)){
              $post_repository->savePostTags($form_tag, $this->post);
            }

            $entityManager->persist($this->post);
            $flush = $entityManager->flush();
            if($flush === null){
              $this->addFlash('success', "El post ha sido editado con exito en la bbdd.");
            }
            return $this->redirectToRoute('index');
          }
        }else{
          $flushs = $entityManager->flush();
          if($flushs === null){
            $this->addFlash('danger', 'Estas intentando editar un post que no te pertence');
          }
          return $this->redirectToRoute('index');
        }
      }
      return $this->render('post/edit.html.twig', [
        'title' => 'Editar categoria',
        'form' => $form->createView(),
        'post' => $this->post,
        'tags_values' => $post_tags,
      ]);
    }

    /**
     * @Route("/post_delete/{id}", name="post_delete")
     */
    public function delete($id, Request $request, ManagerRegistry $doctrine){
      $entityManager = $doctrine->getManager();
      $this->post = $entityManager->getRepository(Post::class)->find($id);
      $tag_repo = $entityManager->getRepository(Tag::class);

      //capture userLogin $this->getUser()->getId()
      if($this->getUser()->getId() === $this->post->getUser()->getId()){
          $post_tags =  $this->post->getTag();

          foreach ($post_tags as $post_tag) {
            $tag_id = $post_tag->getId();
            $tag = $tag_repo->find($tag_id);
            $entityManager->remove($tag);
          }

          $entityManager->remove($this->post);
          $flush = $entityManager->flush();
          if($flush === null){
            $this->addFlash('success', "El post" . '""' . $this->post->getTitle(). '""' . "ha sido eliminada con exito.");
          }
      }else{
        $flushs = $entityManager->flush();
        if($flushs === null){
            $this->addFlash('danger', 'Estas intentando borrar un post que no te pertence');
        }
      }
      return $this->redirectToRoute('index');
    }

    /**
     * @Route("/postPorTags/{name}", name="postPorTags")
     */
    public function tagsPost($name,ManagerRegistry $doctrine): Response
    {
      $entityManager = $doctrine->getManager();
      $tag_repository = $entityManager->getRepository(Tag::class);
      $tags = $tag_repository->findByName($name);
      return $this->render('tag/tags_post.html.twig', [
        'title' => $name,
        'tags' => $tags,
      ]);
    }

    /**
     * @Route("/getUsersAjax", name="getUsersAjax")
     */
    public function getUsersAjax(ManagerRegistry $doctrine){
      $users = $doctrine->getManager()->getRepository(User::class)->findAll();
      $data = [];
      $idx = 0;
      foreach ($users as $user){
        $temp = [
        'id' => $user->getId(),
        'mail' => $user->getEmail(),
        'img' => $user->getImg(),
        'name' => $user->getName(),
        'roles' => $user->getRoles(),
        ];
        $data[$idx++] = $temp;
      }
      return new JsonResponse($data);
    }


}
