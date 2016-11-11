<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Entry;
use BlogBundle\Form\EntryType;
use Symfony\Component\HttpFoundation\Session\Session;

class EntryController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function addAction(Request $request) {
        $entry = new Entry();
        $form = $this->createForm(EntryType::class, $entry);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                // Obtenemos la categoría
                $categoryRepo = $em->getRepository('BlogBundle:Category');
                $category = $categoryRepo->find($form->get('category')->getData());
                // Obtenemos el usuario de la sesión
                $user = $this->getUser();
                // Obtenemos el fichero y hacemos upload
                $file = $form['image']->getData();
                $ext = $file->guessExtension();
                $file_name = time() . "." . $ext;
                $file->move("uploads", $file_name);

                // Manual
                $entry->setTitle($form->get('title')->getData());
                $entry->setContent($form->get('content')->getData());
                $entry->setStatus($form->get('status')->getData());
                $entry->setCategory($category);
                $entry->setUser($user);
                $entry->setImage($file_name);

                $em->persist($entry);
                $flush = $em->flush();

                // Obtenemos el repositorio de entradas
                $entryRepo = $em->getRepository('BlogBundle:Entry');
                // Añadimos las entradas
                $entryRepo->saveEntryTags(
                        $form->get('tags')->getData(), $form->get('title')->getData(), $category, $user
                );

                if ($flush == null) {
                    $status = 'La entrada se ha creado correctamente';
                } else {
                    $status = 'La entrada no se ha creado';
                }
            } else {
                $status = 'La entrada no se ha creado';
            }
            $this->session->getFlashBag()->add('status', $status);
            return $this->redirectToRoute("blog_homepage");
        }

        return $this->render('BlogBundle:Entry:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $categoryRepo = $em->getRepository('BlogBundle:Category');
        $categories = $categoryRepo->findAll();
        $entryRepo = $em->getRepository('BlogBundle:Entry');
        $entries = $entryRepo->findAll();
        return $this->render('BlogBundle:Entry:index.html.twig', array(
                    'entries' => $entries,
                    'categories' => $categories
        ));
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('BlogBundle:Entry');
        $entry = $repo->find($id);

        $status = '';
        if ($entry == null) {
            $status = 'La entrada no se ha encontrado';
            $this->session->getFlashBag()->add('status', $status);
            return $this->redirectToRoute("blog_index_entry");
        }

        $form = $this->createForm(EntryType::class, $entry);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entry);
                $flush = $em->flush();

                if ($flush == null) {
                    $status = 'La entrada se ha editado correctamente';
                } else {
                    $status = 'La entrada no se ha podido editar';
                }
            } else {
                $status = 'La entrada no se ha creado';
            }
            $this->session->getFlashBag()->add('status', $status);
            //return $this->redirectToRoute("blog_index_entry");
        }

        return $this->render('BlogBundle:Entry:edit.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entryRepo = $em->getRepository('BlogBundle:Entry');
        $entryTagRepo = $em->getRepository('BlogBundle:EntryTag');
        $entry = $entryRepo->find($id);

        $status = '';
        if ($entry == null) {
            $status = 'La entrada no se ha encontrado';
        } else {
            $entryTag = $entry->getEntryTag();
            if ($entryTag){
                foreach($entryTag as $et){
                    $em->remove($et);
                    $em->flush();
                }
            }
            $em->remove($entry);
            $flush = $em->flush();
            $status = 'La entrada se ha borrado correctamente';
        }
        $this->session->getFlashBag()->add('status', $status);
        return $this->redirectToRoute("blog_homepage");
    }

}
