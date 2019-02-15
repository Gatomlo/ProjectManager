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
     * @var string|null
     *
     * @ORM\Column(name="intervenant", type="string", length=255, nullable=true)
     */
    private $intervenant;

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
     * @var string|null
     *
     * @ORM\Column(name="Project", type="string", length=255, nullable=true)
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
}
