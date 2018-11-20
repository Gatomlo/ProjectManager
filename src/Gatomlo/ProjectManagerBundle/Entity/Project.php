<?php

namespace Gatomlo\ProjectManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Project
 *
 * @ORM\Table(name="pm_project")
 * @ORM\Entity(repositoryClass="Gatomlo\ProjectManagerBundle\Repository\ProjectRepository")
 */
class Project
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
     * @ORM\Column(name="name", type="string", length=150)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url", type="text", nullable=true)
     */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation", type="datetime")
     */
    private $creation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="endtime", type="datetime", nullable=true)
     */
    private $endtime;

    /**
     * @var \stdClass|null
     *
     * @ORM\Column(name="parents", type="object", nullable=true)
     */
    private $parents;

    /**
     * @var \stdClass|null
     *
     * @ORM\Column(name="childs", type="object", nullable=true)
     */
    private $childs;

    /**
     * @var \stdClass|null
     *
     * @ORM\Column(name="intervenant", type="object", nullable=true)
     */
    private $intervenant;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="creator", type="object")
     */
    private $creator;

    /**
     * @var \stdClass|null
     *
     * @ORM\ManyToMany(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Tags", cascade={"persist"})
     * @ORM\JoinTable(name="pm_project_tags")
     */
    private $tags;

    /**
     * @var \stdClass|null
     *
     * @ORM\Column(name="tasks", type="object", nullable=true)
     */
    private $tasks;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="archived", type="boolean")
     */
    private $archived;

     /**
     * @ORM\OneToMany(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Status", mappedBy="project", cascade={"persist"})
     */
    private $status;

    /**
    * @ORM\OneToMany(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Event", mappedBy="project", cascade={"persist"})
    */
     private $events;


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
     * Set name.
     *
     * @param string $name
     *
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Project
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set url.
     *
     * @param string|null $url
     *
     * @return Project
     */
    public function setUrl($url = null)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set creation.
     *
     * @param \DateTime $creation
     *
     * @return Project
     */
    public function setCreation(\Datetime $creation)
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
     * Set endtime.
     *
     * @param \DateTime|null $endtime
     *
     * @return Project
     */
    public function setEndtime($endtime = null)
    {
        $this->endtime = $endtime;

        return $this;
    }

    /**
     * Get endtime.
     *
     * @return \DateTime|null
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Set parents.
     *
     * @param \stdClass|null $parents
     *
     * @return Project
     */
    public function setParents($parents = null)
    {
        $this->parents = $parents;

        return $this;
    }

    /**
     * Get parents.
     *
     * @return \stdClass|null
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * Set childs.
     *
     * @param \stdClass|null $childs
     *
     * @return Project
     */
    public function setChilds($childs = null)
    {
        $this->childs = $childs;

        return $this;
    }

    /**
     * Get childs.
     *
     * @return \stdClass|null
     */
    public function getChilds()
    {
        return $this->childs;
    }

    /**
     * Set intervenant.
     *
     * @param \stdClass|null $intervenant
     *
     * @return Project
     */
    public function setIntervenant($intervenant = null)
    {
        $this->intervenant = $intervenant;

        return $this;
    }

    /**
     * Get intervenant.
     *
     * @return \stdClass|null
     */
    public function getIntervenant()
    {
        return $this->intervenant;
    }

    /**
     * Set creator.
     *
     * @param \stdClass $creator
     *
     * @return Project
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator.
     *
     * @return \stdClass
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set tags.
     *
     * @param \stdClass|null $tags
     *
     * @return Project
     */
    public function setTags($tags = null)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags.
     *
     * @return \stdClass|null
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set tasks.
     *
     * @param \stdClass|null $tasks
     *
     * @return Project
     */
    public function setTasks($tasks = null)
    {
        $this->tasks = $tasks;

        return $this;
    }

    /**
     * Get tasks.
     *
     * @return \stdClass|null
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Set archived.
     *
     * @param \stdClass archived
     *
     * @return Project
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Get archived.
     *
     * @return \stdClass
     */
    public function getArchived()
    {
        return $this->archived;
    }

    public function __construct()
    {
      $this->tags = new ArrayCollection();
      $this->creation = new \Datetime();
    }

    // Notez le singulier, on ajoute une seule catégorie à la fois
    public function addTag( $tag)
    {
      // Ici, on utilise l'ArrayCollection vraiment comme un tableau
      $this->tags[] = $tag;
    }

    public function removeTag(Tag $tag)
    {
      // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
      $this->tagss->removeElement($tag);
    }


    /**
     * Add status.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Status $status
     *
     * @return Project
     */
    public function addStatus(\Gatomlo\ProjectManagerBundle\Entity\Status $status)
    {
        $this->status[] = $status;

        return $this;
    }

    /**
     * Remove status.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Status $status
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeStatus(\Gatomlo\ProjectManagerBundle\Entity\Status $status)
    {
        return $this->status->removeElement($status);
    }

    /**
     * Get status.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set events.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Event|null $events
     *
     * @return Project
     */
    public function setEvents(\Gatomlo\ProjectManagerBundle\Entity\Event $events = null)
    {
        $this->events = $events;

        return $this;
    }

    /**
     * Get events.
     *
     * @return \Gatomlo\ProjectManagerBundle\Entity\Event|null
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add event.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Event $event
     *
     * @return Project
     */
    public function addEvent(\Gatomlo\ProjectManagerBundle\Entity\Event $event)
    {
        $this->events[] = $event;
        $event->setProject($this);

        return $this;
    }

    /**
     * Remove event.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Event $event
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeEvent(\Gatomlo\ProjectManagerBundle\Entity\Event $event)
    {
        return $this->events->removeElement($event);
    }
}
