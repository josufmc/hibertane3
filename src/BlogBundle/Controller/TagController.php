<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Tag;
use BlogBundle\Form\TagType;
use Symfony\Component\HttpFoundation\Session\Session;

class TagController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function addAction(Request $request) {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()){
            if ($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($tag);
                $flush = $em->flush();
                
                if ($flush == null){
                    $status = 'La etiqueta se ha creado correctamente';
                } else {
                    $status = 'La etiqueta no se ha creado';
                }
            } else {
                $status = 'La etiqueta no se ha creado';
            }
            $this->session->getFlashBag()->add('status', $status);
            return $this->redirectToRoute("blog_index_tag");
        }
        
        return $this->render('BlogBundle:Tag:add.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function indexAction(Request $request) {      
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('BlogBundle:Tag');
        $tags = $repo->findAll();
        return $this->render('BlogBundle:Tag:index.html.twig', array(
            'tags' => $tags
        ));
    }
    
    public function deleteAction($id) {      
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('BlogBundle:Tag');
        $tag = $repo->find($id);
        
        $status = '';
        if ($tag == null){
            $status = 'La tag no se ha encontrado'; 
        }elseif( count($tag->getEntryTag()) > 0){
            $status = 'La tag tiene entradas asignadas'; 
        }else {
            $em->remove($tag);
            $flush = $em->flush();
            $status = 'La tag se ha borrado correctamente';
        }
        $this->session->getFlashBag()->add('status', $status);
        return $this->redirectToRoute("blog_index_tag");
    }

}
