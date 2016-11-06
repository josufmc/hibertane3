<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction(){
        return $this->render('BlogBundle:Default:index.html.twig');
    }
    
    public function indexOld()
    {
        /*
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("BlogBundle:Entry");
        $entries = $repo->findAll();
        
        foreach($entries as $entry){
            echo($entry->getTitle() . '<br>');
            echo($entry->getCategory()->getName() . '<br>');
            echo($entry->getUser()->getName() . '<br>');
            
            $tags = $entry->getEntryTag();
            foreach($tags as $tag){
                echo('-' . $tag->getTag()->getName() . '<br>');
            }
            echo('<hr>');
        }
        */
        
        /*
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("BlogBundle:Category");
        $categories = $repo->findAll();
        
        foreach($categories as $category){
            echo($category->getName() . '<br>');
            
            $entries = $category->getEntries();
            foreach($entries as $entry){
                echo('-' . $entry->getTitle() . '<br>');
            }
            echo('<hr>');
        }
        */
        
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("BlogBundle:Tag");
        $tags = $repo->findAll();
        
        foreach($tags as $tag){
            echo($tag->getName() . '<br>');
            
            $entryTags = $tag->getEntryTag();
            foreach($entryTags as $entryTag){
                echo('-' . $entryTag->getEntry()->getTitle() . '<br>');
            }
            echo('<hr>');
        }
        
        die();
        //return $this->render('BlogBundle:Default:index.html.twig');
    }
}
