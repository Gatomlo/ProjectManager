<?php

namespace Gatomlo\ProjectManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="pm_event")
 * @ORM\Entity(repositoryClass="Gatomlo\ProjectManagerBundle\Repository\EventRepository")
 */
class Event
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
     * @ORM\Column(name="Title", type="string", length=150)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text")
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation", type="datetime")
     */
    private $creation;

    /**
     * @var \Date|null
     *
     * @ORM\Column(name="enddate", type="datetime", nullable=true)
     */
    private $enddate;

    /**
     * @var \Date
     *
     * @ORM\Column(name="startdate", type="datetime")
     */
    private $startdate;

    /**
     * @ORM\ManyToOne(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Type", inversedBy="events", cascade={"persist"})
     *
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Project", inversedBy="events", cascade={"persist"})
     *
     */
    private $project;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="creator", type="object")
     */
    private $creator;

    /**
     * @var \stdClass|null
     *
     * @ORM\Column(name="intervenants", type="object", nullable=true)
     */
    private $intervenants;

    /**
     * @var \stdClass|null
     *
     * @ORM\Column(name="Tags", type="object", nullable=true)
     */
    private $tags;


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
     * Set title.
     *
     * @param string $title
     *
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Event
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
     * Set url.
     *
     * @param string|null $url
     *
     * @return Event
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
     * @return Event
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
     * Set enddate.
     *
     * @param \DateTime|null $enddate
     *
     * @return Event
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
     * Set startdate.
     *
     * @param \DateTime $startdate
     *
     * @return Event
     */
    public function setStartdate($startdate)
    {

        $this->startdate = $startdate;

        return $this;
    }

    /**
     * Get startdate.
     *
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set type.
     *
     * @param \stdClass $type
     *
     * @return Event
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return \stdClass
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set project.
     *
     * @param \stdClass $project
     *
     * @return Event
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project.
     *
     * @return \stdClass
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set creator.
     *
     * @param \stdClass $creator
     *
     * @return Event
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
     * Set intervenants.
     *
     * @param \stdClass|null $intervenants
     *
     * @return Event
     */
    public function setIntervenants($intervenants = null)
    {
        $this->intervenants = $intervenants;

        return $this;
    }

    /**
     * Get intervenants.
     *
     * @return \stdClass|null
     */
    public function getIntervenants()
    {
        return $this->intervenants;
    }

    /**
     * Set tags.
     *
     * @param \stdClass|null $tags
     *
     * @return Event
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
     * Constructor
     */
    public function __construct()
    {
        $this->type = new \Doctrine\Common\Collections\ArrayCollection();
        $this->project = new \Doctrine\Common\Collections\ArrayCollection();
        $this->creation = new \Datetime();
    }

    /**
     * Add type.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Type $type
     *
     * @return Event
     */
    public function addType(\Gatomlo\ProjectManagerBundle\Entity\Type $type)
    {
        $this->type[] = $type;

        return $this;
    }

    /**
     * Remove type.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Type $type
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeType(\Gatomlo\ProjectManagerBundle\Entity\Type $type)
    {
        return $this->type->removeElement($type);
    }

    /**
     * Add project.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Project $project
     *
     * @return Event
     */
    public function addProject(\Gatomlo\ProjectManagerBundle\Entity\Project $project)
    {
        $this->project[] = $project;

        return $this;
    }

    /**
     * Remove project.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Project $project
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeProject(\Gatomlo\ProjectManagerBundle\Entity\Project $project)
    {
        return $this->project->removeElement($project);
    }

    /**
     * Set types.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Type|null $types
     *
     * @return Event
     */
    public function setTypes(\Gatomlo\ProjectManagerBundle\Entity\Type $types = null)
    {
        $this->types = $types;

        return $this;
    }

    /**
     * Get types.
     *
     * @return \Gatomlo\ProjectManagerBundle\Entity\Type|null
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Set endtime.
     *
     * @param \DateTime|null $endtime
     *
     * @return Event
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
     * Set starttime.
     *
     * @param \DateTime $starttime
     *
     * @return Event
     */
    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;

        return $this;
    }

    /**
     * Get starttime.
     *
     * @return \DateTime
     */
    public function getStarttime()
    {
        return $this->starttime;
    }
}
