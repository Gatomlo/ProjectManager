<?php

namespace Gatomlo\ProjectManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * People
 *
 * @ORM\Table(name="pm_people")
 * @ORM\Entity(repositoryClass="Gatomlo\ProjectManagerBundle\Repository\PeopleRepository")
 */
class People
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
     * @ORM\Column(name="firstName", type="string", length=125)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=125)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=125, nullable=true)
     */
    private $phone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rue", type="string", length=200, nullable=true)
     */
    private $streetAndNumer;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cityAndCode", type="string", length=200, nullable=true)
     */
    private $cityAndCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="instutition", type="string", length=255, nullable=true)
     */
    private $institution;

    /**
     * @var string|null
     *
     * @ORM\Column(name="streetOfInstitution", type="string", length=255, nullable=true)
     */
    private $streetOfInstitution;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cityAndCodeOfInstitution", type="string", length=255, nullable=true)
     */
    private $cityAndCodeOfInstitution;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fonction", type="string", length=255, nullable=true)
     */
    private $fonction;

    /**
     * @var string|null
     *
     * @ORM\Column(name="matricule", type="string", length=255, nullable=true)
     */
    private $matricule;

    /**
     * @var string|null
     *
     * @ORM\Column(name="diplome", type="string", length=255, nullable=true)
     */
    private $diplome;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Intervenant", mappedBy="people", cascade={"persist"})
     *
     */
    private $intervenant;
    /**
     * @var \stdClass|null
     *
     * @ORM\ManyToMany(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Tags", cascade={"persist"})
     * @ORM\JoinTable(name="pm_people_tags")
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
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return People
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return People
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get Identity.
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->lastName.' '.$this->firstName;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return People
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set telephone.
     *
     * @param string $telephone
     *
     * @return People
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set rue.
     *
     * @param string|null $rue
     *
     * @return People
     */
    public function setRue($rue = null)
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * Get rue.
     *
     * @return string|null
     */
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * Set cityAndCode.
     *
     * @param string|null $cityAndCode
     *
     * @return People
     */
    public function setCityAndCode($cityAndCode = null)
    {
        $this->cityAndCode = $cityAndCode;

        return $this;
    }

    /**
     * Get cityAndCode.
     *
     * @return string|null
     */
    public function getCityAndCode()
    {
        return $this->cityAndCode;
    }

    /**
     * Set instutition.
     *
     * @param string|null $instutition
     *
     * @return People
     */
    public function setInstutition($instutition = null)
    {
        $this->instutition = $instutition;

        return $this;
    }

    /**
     * Get instutition.
     *
     * @return string|null
     */
    public function getInstutition()
    {
        return $this->instutition;
    }

    /**
     * Set streetOfInstitution.
     *
     * @param string|null $streetOfInstitution
     *
     * @return People
     */
    public function setStreetOfInstitution($streetOfInstitution = null)
    {
        $this->streetOfInstitution = $streetOfInstitution;

        return $this;
    }

    /**
     * Get streetOfInstitution.
     *
     * @return string|null
     */
    public function getStreetOfInstitution()
    {
        return $this->streetOfInstitution;
    }

    /**
     * Set cityAndCodeOfInstitution.
     *
     * @param string|null $cityAndCodeOfInstitution
     *
     * @return People
     */
    public function setCityAndCodeOfInstitution($cityAndCodeOfInstitution = null)
    {
        $this->cityAndCodeOfInstitution = $cityAndCodeOfInstitution;

        return $this;
    }

    /**
     * Get cityAndCodeOfInstitution.
     *
     * @return string|null
     */
    public function getCityAndCodeOfInstitution()
    {
        return $this->cityAndCodeOfInstitution;
    }

    /**
     * Set fonction.
     *
     * @param string|null $fonction
     *
     * @return People
     */
    public function setFonction($fonction = null)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction.
     *
     * @return string|null
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Set diplome.
     *
     * @param string|null $diplome
     *
     * @return People
     */
    public function setDiplome($diplome = null)
    {
        $this->diplome = $diplome;

        return $this;
    }

    /**
     * Get diplome.
     *
     * @return string|null
     */
    public function getDiplome()
    {
        return $this->diplome;
    }

    /**
     * Set phone.
     *
     * @param string|null $phone
     *
     * @return People
     */
    public function setPhone($phone = null)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set streetAndNumer.
     *
     * @param string|null $streetAndNumer
     *
     * @return People
     */
    public function setStreetAndNumer($streetAndNumer = null)
    {
        $this->streetAndNumer = $streetAndNumer;

        return $this;
    }

    /**
     * Get streetAndNumer.
     *
     * @return string|null
     */
    public function getStreetAndNumer()
    {
        return $this->streetAndNumer;
    }

    /**
     * Set institution.
     *
     * @param string|null $institution
     *
     * @return People
     */
    public function setInstitution($institution = null)
    {
        $this->institution = $institution;

        return $this;
    }

    /**
     * Get institution.
     *
     * @return string|null
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Set comment.
     *
     * @param string|null $comment
     *
     * @return People
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

    /**
     * Set matricule.
     *
     * @param string|null $matricule
     *
     * @return People
     */
    public function setMatricule($matricule = null)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule.
     *
     * @return string|null
     */
    public function getMatricule()
    {
        return $this->matricule;
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
     * @return People
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

    /**
     * Add tag.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Tags $tag
     *
     * @return People
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
}
