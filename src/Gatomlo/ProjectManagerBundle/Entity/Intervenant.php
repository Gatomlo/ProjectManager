<?php

namespace Gatomlo\ProjectManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Intervenant
 *
 * @ORM\Table(name="intervenant")
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
     * @var \stdClass
     *
     * @ORM\Column(name="project", type="object")
     */
    private $project;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="people", type="object")
     */
    private $people;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="function", type="object")
     */
    private $function;


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
     * Set function.
     *
     * @param \stdClass $function
     *
     * @return Intervenant
     */
    public function setFunction($function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get function.
     *
     * @return \stdClass
     */
    public function getFunction()
    {
        return $this->function;
    }
}
