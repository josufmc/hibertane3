<?php

namespace BlogBundle\Entity;
use BlogBundle\Entity\Entry;
use BlogBundle\Entity\Tag;
/**
 * EntryTag
 */
class EntryTag
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \BlogBundle\Entity\Entry
     */
    private $entry;

    /**
     * @var \BlogBundle\Entity\Tag
     */
    private $tag;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set entry
     *
     * @param \BlogBundle\Entity\Entries $entry
     *
     * @return EntryTag
     */
    public function setEntry(Entry $entry = null)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get entry
     *
     * @return \BlogBundle\Entity\Entries
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set tag
     *
     * @param \BlogBundle\Entity\Tags $tag
     *
     * @return EntryTag
     */
    public function setTag(Tag $tag = null)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \BlogBundle\Entity\Tags
     */
    public function getTag()
    {
        return $this->tag;
    }
}

