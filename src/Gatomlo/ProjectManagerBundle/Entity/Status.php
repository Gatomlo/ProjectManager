<?php

namespace Gatomlo\ProjectManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Status
 *
 * @ORM\Table(name="pm_status")
 * @ORM\Entity(repositoryClass="Gatomlo\ProjectManagerBundle\Repository\StatusRepository")
 */
class Status
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
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Project", mappedBy="status", cascade={"persist"})
     *
     */
    private $project;



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
     * @return Status
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
     * @return Status
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
     * Set project.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Project|null $project
     *
     * @return Status
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
     * Constructor
     */
    public function __construct()
    {
        $this->project = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add project.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Project $project
     *
     * @return Status
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
}
