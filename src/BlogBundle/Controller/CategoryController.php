<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Category;
use BlogBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\Session\Session;

class CategoryController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function addAction(Request $request) {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $flush = $em->flush();

                if ($flush == null) {
                    $status = 'La categoría se ha creado correctamente';
                } else {
                    $status = 'La categoría no se ha creado';
                }
            } else {
                $status = 'La categoría no se ha creado';
            }
            $this->session->getFlashBag()->add('status', $status);
            return $this->redirectToRoute("blog_index_category");
        }

        return $this->render('BlogBundle:Category:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('BlogBundle:Category');
        $categories = $repo->findAll();
        return $this->render('BlogBundle:Category:index.html.twig', array(
                    'categories' => $categories
        ));
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('BlogBundle:Category');
        $category = $repo->find($id);

        $status = '';
        if ($category == null) {
            $status = 'La categoría no se ha encontrado';
            $this->session->getFlashBag()->add('status', $status);
            return $this->redirectToRoute("blog_index_category");
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $flush = $em->flush();

                if ($flush == null) {
                    $status = 'La categoría se ha editado correctamente';
                } else {
                    $status = 'La categoría no se ha podido editar';
                }
            } else {
                $status = 'La categoría no se ha creado';
            }
            $this->session->getFlashBag()->add('status', $status);
            //return $this->redirectToRoute("blog_index_category");
        }
        
        return $this->render('BlogBundle:Category:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('BlogBundle:Category');
        $category = $repo->find($id);

        $status = '';
        if ($category == null) {
            $status = 'La categoría no se ha encontrado';
        } elseif (count($category->getEntries()) > 0) {
            $status = 'La categoría tiene entradas asignadas';
        } else {
            $em->remove($category);
            $flush = $em->flush();
            $status = 'La categoría se ha borrado correctamente';
        }
        $this->session->getFlashBag()->add('status', $status);
        return $this->redirectToRoute("blog_index_category");
    }

}
