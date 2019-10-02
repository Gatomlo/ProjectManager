<?php

namespace Gatomlo\ProjectManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

 /**
  * Document
  *
  * @ORM\Table(name="pm_document")
  * @ORM\Entity(repositoryClass="Gatomlo\ProjectManagerBundle\Repository\DocumentRepository")
  * @Vich\Uploadable
  */
class Document
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
    * @ORM\ManyToOne(targetEntity="Gatomlo\ProjectManagerBundle\Entity\Project", inversedBy="document", cascade={"persist"})
    */
    private $project;

    /**
    * NOTE: This is not a mapped field of entity metadata, just a simple property.
    *
    * @Vich\UploadableField(mapping="product_image", fileNameProperty="documentName", size="documentSize")
    *
    * @var File
    */
   private $documentFile;

   /**
    * @ORM\Column(type="string", length=255)
    *
    * @var string
    */
   private $documentName;

   /**
    * @ORM\Column(type="integer")
    *
    * @var integer
    */
   private $documentSize;

   /**
    * @ORM\Column(type="datetime", nullable=true)
    *
    * @var \DateTime
    */
   private $updatedAt;


   /**
    * Constructor
    */
   public function __construct()
   {
       $this->project = new \Doctrine\Common\Collections\ArrayCollection();
   }

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
   * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
   * of 'UploadedFile' is injected into this setter to trigger the update. If this
   * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
   * must be able to accept an instance of 'File' as the bundle will inject one here
   * during Doctrine hydration.
   *
   * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $documentFile
   */
  public function setDocumentFile(?File $documentFile = null): void
  {
      $this->documentFile = $documentFile;

      if (null !== $documentFile) {
          // It is required that at least one field changes if you are using doctrine
          // otherwise the event listeners won't be called and the file is lost
          $this->updatedAt = new \DateTimeImmutable();
      }
  }

  public function getDocumentFile(): ?File
  {
      return $this->documentFile;
  }

  public function setDocumentName(?string $documentName): void
  {
      $this->documentName = $documentName;
  }

  public function getDocumentName(): ?string
  {
      return $this->documentName;
  }

  public function setDocumentSize(?int $documentSize): void
  {
      $this->documentSize = $documentSize;
  }

  public function getDocumentSize(): ?int
  {
      return $this->documentSize;
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
    * Add project.
    *
    * @param \Gatomlo\ProjectManagerBundle\Entity\Project $project
    *
    * @return Document
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
