<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Form\UserType;

class UserController extends AbstractController
{


    /**
     * @Route("/register", name="register")
     */
    public function register(
      Request $request, ManagerRegistry $doctrine,
      UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $doctrine->getManager();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
          $user->setRoles(['ROLE_USER']);
          $user->setImg('defaul.jgp');
          $user->setActive(true);
          $user->setDate(new \DateTime('now'));

          $hashedPassword = $passwordHasher->hashPassword( $user,$form['password']->getData());
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
    }// fin function



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
    }// fin function

    /**
     * @Route("/logout", name="logout")
     */
      public function logout(){
      }// fin function


}
