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
}
