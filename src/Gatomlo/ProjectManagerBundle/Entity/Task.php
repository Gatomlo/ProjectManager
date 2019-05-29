<?php

namespace Gatomlo\ProjectManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="pm_task")
 * @ORM\Entity(repositoryClass="Gatomlo\ProjectManagerBundle\Repository\TaskRepository")
 */
class Task
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
    * @var \DateTime
    *
    * @ORM\Column(name="creation", type="datetime",nullable=true)
    */
   private $creation;

   /**
    * @var \Date|null
    *
    * @ORM\Column(name="enddate", type="datetime", nullable=true)
    */
   private $enddate;

   /**
    * @var \Date|null
    *
    * @ORM\Column(name="executiondate", type="datetime", nullable=true)
    */
   private $executiondate;

   /**
    * @ORM\ManyToOne(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Project", inversedBy="tasks", cascade={"persist"})
    *
    */
   private $project;

   /**
    * @var \stdClass|null
    *
    * @ORM\ManyToMany(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Tags", cascade={"persist"})
    * @ORM\JoinTable(name="pm_task_tags")
    */
   private $tags;

   /**
    * @var \Boolean
    *
    * @ORM\Column(name="closed", type="boolean")
    */
   private $closed = FALSE;

   /**
    * @var \stdClass|null
    *
    * @ORM\ManyToMany(targetEntity="Gatomlo\UserBundle\Entity\User", cascade={"persist"})
    * @ORM\JoinTable(name="pm_task_owner")
    */
   private $owner;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set creation.
     *
     * @param \DateTime $creation
     *
     * @return Task
     */
    public function setCreation($creation)
    {
        $this->creation = $creation;

        return $this;
    }

    /**
     * Get creation.
     *
     * @return \DateTime
     */
    public function getCreation()
    {
        return $this->creation;
    }

    /**
     * Set enddate.
     *
     * @param \DateTime|null $enddate
     *
     * @return Task
     */
    public function setEnddate($enddate = null)
    {
        $this->enddate = $enddate;

        return $this;
    }

    /**
     * Get enddate.
     *
     * @return \DateTime|null
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * Set executiondate.
     *
     * @param \DateTime|null $executiondate
     *
     * @return Task
     */
    public function setExecutiondate($executiondate = null)
    {
        $this->executiondate = $executiondate;

        return $this;
    }

    /**
     * Get executiondate.
     *
     * @return \DateTime|null
     */
    public function getExecutiondate()
    {
        return $this->executiondate;
    }

    /**
     * Set closed.
     *
     * @param bool $closed
     *
     * @return Task
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;

        return $this;
    }

    /**
     * Get closed.
     *
     * @return bool
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * Set project.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Project|null $project
     *
     * @return Task
     */
    public function setProject(\Gatomlo\ProjectManagerBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project.
     *
     * @return \Gatomlo\ProjectManagerBundle\Entity\Project|null
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Add tag.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Tags $tag
     *
     * @return Task
     */
    public function addTag(\Gatomlo\ProjectManagerBundle\Entity\Tags $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Tags $tag
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTag(\Gatomlo\ProjectManagerBundle\Entity\Tags $tag)
    {
        return $this->tags->removeElement($tag);
    }

    /**
     * Get tags.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add owner.
     *
     * @param \Gatomlo\UserBundle\Entity\User $owner
     *
     * @return Task
     */
    public function addOwner(\Gatomlo\UserBundle\Entity\User $owner)
    {
        $this->owner[] = $owner;

        return $this;
    }

    /**
     * Remove owner.
     *
     * @param \Gatomlo\UserBundle\Entity\User $owner
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeOwner(\Gatomlo\UserBundle\Entity\User $owner)
    {
        return $this->owner->removeElement($owner);
    }

    /**
     * Get owner.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOwner()
    {
        return $this->owner;
    }

    public function isOwner($owner)
    {
      $realOwner = $this->owner;
      foreach ($realOwner as $key => $value) {
        if($value == $owner){
          return true;
        }
      }
      return false;
    }
}
