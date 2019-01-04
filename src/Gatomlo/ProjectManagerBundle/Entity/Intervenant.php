<?php

namespace Gatomlo\ProjectManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Intervenant
 *
 * @ORM\Table(name="pm_intervenant")
 * @ORM\Entity(repositoryClass="Gatomlo\ProjectManagerBundle\Repository\IntervenantRepository")
 */
class Intervenant
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
    * @ORM\ManyToOne(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Project", inversedBy="intervenant", cascade={"persist"})
    */
    private $project;

    /**
    * @ORM\ManyToOne(targetEntity="Gatomlo\ProjectManagerBundle\Entity\People", inversedBy="intervenant", cascade={"persist"})
    */
    private $people;

    /**
    * @ORM\ManyToOne(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Job", inversedBy="intervenant", cascade={"persist"})
    */
    private $job;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;


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
     * Set project.
     *
     * @param \stdClass $project
     *
     * @return Intervenant
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
     * Set people.
     *
     * @param \stdClass $people
     *
     * @return Intervenant
     */
    public function setPeople($people)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Get people.
     *
     * @return \stdClass
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * Set job.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Job|null $job
     *
     * @return Intervenant
     */
    public function setJob(\Gatomlo\ProjectManagerBundle\Entity\Job $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job.
     *
     * @return \Gatomlo\ProjectManagerBundle\Entity\Job|null
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set comment.
     *
     * @param string|null $comment
     *
     * @return Intervenant
     */
    public function setComment($comment = null)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string|null
     */
    public function getComment()
    {
        return $this->comment;
    }
}
