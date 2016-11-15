<?php

namespace BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;
use BlogBundle\Entity\Tag;
use BlogBundle\Entity\EntryTag;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Description of EntryRepository
 *
 * @author Josu
 */
class EntryRepository extends EntityRepository {

    public function saveEntryTags($tags = null, $title = null, $category = null, $user = null, $entry = null) {
        //$em = $this->getDoctrine->getManager();   // Desde el repositorio, ya no se hace así.
        $em = $this->getEntityManager();    // Esto cambia desde el repositorio
        $tagRepository = $em->getRepository("BlogBundle:Tag");
        
        if ($entry == null) {
            $entry = $this->findOneBy(array(
                'title' => $title,
                'category' => $category,
                'user' => $user
            ));
        }
        
        $tags = explode(",", $tags);
        foreach($tags as $tag){
            $tag = trim($tag);
            $isset_tag = $tagRepository->findOneBy(array(
                'name' => $tag
            ));
            
            if (count($isset_tag) == 0){
                $tag_obj = new Tag();
                $tag_obj->setName($tag);
                $tag_obj->setDescription($tag);
                if (!empty($tag_obj)){
                    $em->persist($tag_obj);
                    $em->flush();
                }
            }
            $tag = $tagRepository->findOneBy(array('name' => $tag));
            
            $entryTag = new EntryTag();
            $entryTag->setEntry($entry);
            $entryTag->setTag($tag);
            $em->persist($entryTag);   
        }
        $flush = $em->flush();
        return $flush;
    }
    
    public function getPaginatedEntries($pageSize = 3, $currentPage=1){
        $em = $this->getEntityManager();
        $dql = "SELECT e FROM BlogBundle\Entity\Entry e ORDER BY e.id DESC";
        $query = $em->createQuery($dql)
                ->setFirstResult($pageSize * ($currentPage - 1))
                ->setMaxResults($pageSize)
                ;
        $paginator = new Paginator($query, $fetchJoinCollection = true);
        return $paginator;
    }

}
