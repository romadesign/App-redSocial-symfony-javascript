<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileEditType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Form\UserType;

class UserController extends AbstractController
{
  private $user;
  private $session;
  public function __construct()
  {
    $this->user = new User();
    $this->session = new Session();
  }
  /**
   * @Route("/register", name="register")
   */
  public function register(
    Request $request,
    ManagerRegistry $doctrine,
    UserPasswordHasherInterface $passwordHasher
  ): Response {
    $entityManager = $doctrine->getManager();
    $user = new User();
    $form = $this->createForm(UserType::class, $user);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $user->setRoles(['ROLE_USER']);
      $user->setImg('perfil.png');
      $user->setActive(true);
      $user->setDate(new \DateTime('now'));

      $hashedPassword = $passwordHasher->hashPassword($user, $form['password']->getData());
      $user->setPassword($hashedPassword);

      // tell Doctrine you want to (eventually) save the Product (no queries yet)
      $entityManager->persist($user);

      // actually executes the queries (i.e. the INSERT query)
      $entityManager->flush();
      return $this->redirectToRoute('index');
    }

    return $this->render('user/register.html.twig', [
      'title' => 'Registro',
      'form' => $form->createView(),
    ]);
  } // fin function



  /**
   * @Route("/login", name="login")
   */
  public function login(AuthenticationUtils $authenticationUtils): Response
  {
    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();
    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();
    return $this->render('user/login.html.twig', [
      'last_username' => $lastUsername,
      'error'         => $error,
      'title' => 'Login',
    ]);
  } // fin function

  /**
   * @Route("/logout", name="logout")
   */
  public function logout()
  {
  } // fin function

  /**
   * @Route("/profile_edit/{id}", name="profile_edit")
   */
  public function profile(Request $request, ManagerRegistry $doctrine, $id): Response
  {
    $entityManager = $doctrine->getManager();
    $this->user = $entityManager->getRepository(User::class)->find($id);
    $user_repository = $entityManager->getRepository(User::class);
    $form = $this->createForm(ProfileEditType::class, $this->user);
    $form->handleRequest($request);
    //validando que el usurio este logeado 
    if ($this->getUser() === null) {
      return $this->redirectToRoute('index');
    }
    if ($this->user === null) {
      return $this->redirectToRoute('index');
    } else {
      //capture userLogin $this->getUser()->getId()
      if ($this->getUser()->getId() === $this->user->getId()) {
        if ($form->isSubmitted() && $form->isValid()) {
          $form_name = $form->get('name')->getData();
          $form_subname = $form->get('subname')->getData();
          $form_email = $form->get('email')->getData();
          $form_image = $form->get('img')->getData();

          //setear los datos
          $this->user->setName($form_name);
          $this->user->setSubname($form_subname);
          $this->user->setEmail($form_email);

          //image
          if ($form_image != null) {
            $name_img = $user_repository->moveImg($form_image);
            $this->user->setImg($name_img);
          }
          $entityManager->persist($this->user);
          $flush = $entityManager->flush();
          if ($flush === null) {
            $this->addFlash('success', "Tu perfil ha sido editado con exito en la bbdd.");
          }
          return $this->redirectToRoute('index');
        }
      } else {
        $flushs = $entityManager->flush();
        if ($flushs === null) {
          $this->addFlash('danger', 'Estas intentando ingresar a unos datos que no te pertenece');
        }
        return $this->redirectToRoute('index');
      }
    }

    return $this->render('user/profile_edit.html.twig', [
      'title' => 'Editar perfil',
      'form' => $form->createView(),
      'user' => $this->user,
    ]);
  } // fin function


}
