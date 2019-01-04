<?php

namespace Gatomlo\ProjectManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Function
 *
 * @ORM\Table(name="pm_function")
 * @ORM\Entity(repositoryClass="Gatomlo\ProjectManagerBundle\Repository\FunctionRepository")
 */
class Job
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
     * @ORM\Column(name="name", type="string", length=125)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Intervenant", mappedBy="job", cascade={"persist"})
     *
     */
    private $intervenant;


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
     * @return Function
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
     * Constructor
     */
    public function __construct()
    {
        $this->intervenant = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add intervenant.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Intervenant $intervenant
     *
     * @return Job
     */
    public function addIntervenant(\Gatomlo\ProjectManagerBundle\Entity\Intervenant $intervenant)
    {
        $this->intervenant[] = $intervenant;

        return $this;
    }

    /**
     * Remove intervenant.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Intervenant $intervenant
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeIntervenant(\Gatomlo\ProjectManagerBundle\Entity\Intervenant $intervenant)
    {
        return $this->intervenant->removeElement($intervenant);
    }

    /**
     * Get intervenant.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIntervenant()
    {
        return $this->intervenant;
    }
}
