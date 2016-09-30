<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Movie
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="movie_image", fileNameProperty="image")
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(name="proposed_by", type="string", nullable=false)
     * @Assert\NotBlank(message="Veuillez renseigner un nom d'utilisateur")
     */
    private $proposedBy;

    /**
     * @var User[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinTable(name="movie_voters",
     *      joinColumns={@ORM\JoinColumn(name="movie_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    private $voters;

    public function __construct()
    {
        $this->voters = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Movie
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Movie
     */
    public function setImage(string $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set proposedBy
     *
     * @param string $proposedBy
     *
     * @return Movie
     */
    public function setProposedBy(string $proposedBy)
    {
        $this->proposedBy = $proposedBy;

        return $this;
    }

    /**
     * Get proposedBy
     *
     * @return string
     */
    public function getProposedBy()
    {
        return $this->proposedBy;
    }

    /**
     * @return User[]|Collection
     */
    public function getVoters()
    {
        return $this->voters;
    }

    /**
     * @param User[]|Collection $voters
     */
    public function setVoters(Collection $voters)
    {
        $this->voters->clear();

        foreach ($voters as $voter) {
            $this->addVoter($voter);
        }
    }

    public function addVoter(User $voter)
    {
        if ($this->voters->contains($voter)) {
            return;
        }

        $this->voters->add($voter);
    }

    public function removeVoter(User $voter)
    {
        $this->voters->removeElement($voter);
    }
}

