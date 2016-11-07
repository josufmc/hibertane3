<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\User;
use BlogBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

class UserController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function loginAction(Request $request) {
        $authenticationUtils = $this->get("security.authentication_utils");
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUserName();

        $user = new User();
        $form = $this->createForm(Usertype::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $user = new User();
                $user->setName($form->get('name')->getData());
                $user->setSurname($form->get('surname')->getData());
                $user->setEmail($form->get('email')->getData());
                $user->setRole('ROLE_USER');
                $user->setImagen(null);
                
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($form->get('password')->getData(), $user->getSalt());
                $user->setPassword($password);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $flush = $em->flush();

                if ($flush == null) {
                    $status = "El usuario se ha creado correctamente";
                } else {
                    $status = "No te has registrado correctamente";
                }
            } else {
                $status = "No te has registrado correctamente";
            }
            $this->session->getFlashBag()->add('status', $status);
        }

        return $this->render('BlogBundle:User:login.html.twig', array(
                    "error" => $error,
                    "last_username" => $lastUsername,
                    "form" => $form->createView()
        ));
    }

}
