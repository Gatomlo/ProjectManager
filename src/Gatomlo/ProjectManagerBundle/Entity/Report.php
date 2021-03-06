<?php

namespace Gatomlo\ProjectManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Report
 *
 * @ORM\Table(name="pm_report")
 * @ORM\Entity(repositoryClass="Gatomlo\ProjectManagerBundle\Repository\ReportRepository")
 */
class Report
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="startDate", type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="endDate", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\ManyToOne(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Project", cascade={"persist"})
     *
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Type", cascade={"persist"})
     *
     */
    private $type;

    /**
     * @var \stdClass|null
     *
     * @ORM\ManyToMany(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Tags", cascade={"persist"})
     * @ORM\JoinTable(name="pm_report_tags")
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity="Gatomlo\ProjectManagerBundle\Entity\People", cascade={"persist"})
     *
     */
    private $intervenant;

    /**
     * @var \stdClass|null
     *
     * @ORM\ManyToMany(targetEntity="Gatomlo\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinTable(name="pm_report_owner")
     */
    private $owner;


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
     * @return Report
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
     * Set intervenant.
     *
     * @param string|null $intervenant
     *
     * @return Report
     */
    public function setIntervenant($intervenant = null)
    {
        $this->intervenant = $intervenant;

        return $this;
    }

    /**
     * Get intervenant.
     *
     * @return string|null
     */
    public function getIntervenant()
    {
        return $this->intervenant;
    }

    /**
     * Set startDate.
     *
     * @param string|null $startDate
     *
     * @return Report
     */
    public function setStartDate($startDate = null)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate.
     *
     * @return string|null
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate.
     *
     * @param \DateTime|null $endDate
     *
     * @return Report
     */
    public function setEndDate($endDate = null)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate.
     *
     * @return \DateTime|null
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set project.
     *
     * @param string|null $project
     *
     * @return Report
     */
    public function setProject($project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project.
     *
     * @return string|null
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set type.
     *
     * @param string|null $type
     *
     * @return Report
     */
    public function setType($type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set tags.
     *
     * @param string|null $tags
     *
     * @return Report
     */
    public function setTags($tags = null)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags.
     *
     * @return string|null
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
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tag.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Tags $tag
     *
     * @return Report
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
     * Add owner.
     *
     * @param \Gatomlo\UserBundle\Entity\User $owner
     *
     * @return Report
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
