<?php

namespace Gatomlo\ProjectManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Project
 *
 * @ORM\Table(name="pm_project")
 * @ORM\Entity(repositoryClass="Gatomlo\ProjectManagerBundle\Repository\ProjectRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
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
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=150, nullable=true)
     */
    private $matricule;

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
     * @ORM\Column(name="endtime", type="date", nullable=true)
     */
    private $endtime;

    /**
    * @ORM\ManyToOne(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Project", inversedBy="childs", cascade={"persist"})
    */

    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Project", mappedBy="parent", cascade={"persist"})
     *
     */
    private $childs;

    /**
     * @ORM\OneToMany(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Intervenant", mappedBy="project", cascade={"persist"})
     *
     */
    private $intervenant;

    /**
     * @ORM\OneToMany(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Document", mappedBy="project", cascade={"persist"})
     *
     */
    private $document;

    /**
     * @var \stdClass|null
     *
     * @ORM\ManyToMany(targetEntity="Gatomlo\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinTable(name="pm_project_owner")
     */
    private $owner;

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
    private $archived = FALSE;

     /**
     * @ORM\ManyToOne(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Status", inversedBy="project", cascade={"persist"})
     */
    private $status;

    /**
    * @ORM\OneToMany(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Event", mappedBy="project", cascade={"persist","remove"})
    */
     private $events;

     /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName", size="imageSize")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $imageSize;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;


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

    public function addTag( $tag)
    {
      // Ici, on utilise l'ArrayCollection vraiment comme un tableau
      $this->tags[] = $tag;
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

    /**
     * Add parent.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Project $parent
     *
     * @return Project
     */
    public function addParent(\Gatomlo\ProjectManagerBundle\Entity\Project $parent)
    {
        $this->parents[] = $parent;

        return $this;
    }

    /**
     * Remove parent.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Project $parent
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeParent(\Gatomlo\ProjectManagerBundle\Entity\Project $parent)
    {
        return $this->parents->removeElement($parent);
    }

    /**
     * Set parent.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Project|null $parent
     *
     * @return Project
     */
    public function setParent(\Gatomlo\ProjectManagerBundle\Entity\Project $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return \Gatomlo\ProjectManagerBundle\Entity\Project|null
     */
    public function getParent()
    {
        return $this->parent;
    }


    /**
     * Add child.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Project $child
     *
     * @return Project
     */
    public function addChild(\Gatomlo\ProjectManagerBundle\Entity\Project $child)
    {
        $this->childs[] = $child;

        return $this;
    }

    /**
     * Remove child.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Project $child
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeChild(\Gatomlo\ProjectManagerBundle\Entity\Project $child)
    {
        return $this->childs->removeElement($child);
    }

    /**
     * Set status.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Status|null $status
     *
     * @return Project
     */
    public function setStatus(\Gatomlo\ProjectManagerBundle\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }


    /**
     * Add intervenant.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Intervenant $intervenant
     *
     * @return Project
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
     * Set matricule.
     *
     * @param string|null $matricule
     *
     * @return Project
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
     * Add owner.
     *
     * @param \Gatomlo\UserBundle\Entity\User $owner
     *
     * @return Project
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

    /**
    * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
    * of 'UploadedFile' is injected into this setter to trigger the update. If this
    * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
    * must be able to accept an instance of 'File' as the bundle will inject one here
    * during Doctrine hydration.
    *
    * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
    */
   public function setImageFile(?File $imageFile = null): void
   {
       $this->imageFile = $imageFile;

       if (null !== $imageFile) {
           // It is required that at least one field changes if you are using doctrine
           // otherwise the event listeners won't be called and the file is lost
           $this->updatedAt = new \DateTimeImmutable();
       }
   }

   public function getImageFile(): ?File
   {
       return $this->imageFile;
   }

   public function setImageName(?string $imageName): void
   {
       $this->imageName = $imageName;
   }

   public function getImageName(): ?string
   {
       return $this->imageName;
   }

   public function setImageSize(?int $imageSize): void
   {
       $this->imageSize = $imageSize;
   }

   public function getImageSize(): ?int
   {
       return $this->imageSize;
   }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Project
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set document.
     *
     * @param \stdClass|null $document
     *
     * @return Project
     */
    public function setDocument($document = null)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return \stdClass|null
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Add document.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Document $document
     *
     * @return Project
     */
    public function addDocument(\Gatomlo\ProjectManagerBundle\Entity\Document $document)
    {
        $this->document[] = $document;

        return $this;
    }

    /**
     * Remove document.
     *
     * @param \Gatomlo\ProjectManagerBundle\Entity\Document $document
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDocument(\Gatomlo\ProjectManagerBundle\Entity\Document $document)
    {
        return $this->document->removeElement($document);
    }
}
