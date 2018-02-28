<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Film
 *
 * @property \DateTime createAt
 * @ORM\Table(name="film")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FilmRepository")
 */
class Film
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
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var bool
     *
     * @ORM\Column(name="isSelected", type="boolean")
     */
    private $isSelected = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="releaseAt", type="datetime", nullable=true)
     */
    private $releaseAt;
    
    /** 
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Saga" , inversedBy="films")
     */
    private $saga;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Category" , inversedBy="films")
     */
    private $categories;
    
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Producer" , inversedBy="films")
     */
    private $producers;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Actor" , inversedBy="films")
     */
    private $actors;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="film")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setCreatedAt( new \DateTime());
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    

    /*3*
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
     * @return Film
     */
    public function setName($name)
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
     * Set description
     *
     * @param string $description
     *
     * @return Film
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Film
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Film
     */
    public function setImage($image)
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

    /**
     * Set isSelected
     *
     * @param boolean $isSelected
     *
     * @return Film
     */
    public function setIsSelected($isSelected)
    {
        $this->isSelected = $isSelected;

        return $this;
    }

    /**
     * Get isSelected
     *
     * @return bool
     */
    public function getIsSelected()
    {
        return $this->isSelected;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set releaseAt
     *
     * @param \DateTime $releaseAt
     *
     * @return Film
     */
    public function setReleaseAt($releaseAt)
    {
        $this->releaseAt = $releaseAt;

        return $this;
    }

    /**
     * Get releaseAt
     *
     * @return \DateTime
     */
    public function getReleaseAt()
    {
        return $this->releaseAt;
    }

    /**
     * Set saga
     *
     * @param \AppBundle\Entity\Saga $saga
     *
     * @return Film
     */
    public function setSaga(\AppBundle\Entity\Saga $saga = null)
    {
        $this->saga = $saga;

        return $this;
    }

    /**
     * Get saga
     *
     * @return \AppBundle\Entity\Saga
     */
    public function getSaga()
    {
        return $this->saga;
    }

    /**
     * Add category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Film
     */
    public function addCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\Category $category
     */
    public function removeCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add producer
     *
     * @param \AppBundle\Entity\Producer $producer
     *
     * @return Film
     */
    public function addProducer(\AppBundle\Entity\Producer $producer)
    {
        $this->producers[] = $producer;

        return $this;
    }

    /**
     * Remove producer
     *
     * @param \AppBundle\Entity\Producer $producer
     */
    public function removeProducer(\AppBundle\Entity\Producer $producer)
    {
        $this->producers->removeElement($producer);
    }

    /**
     * Get producers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducers()
    {
        return $this->producers;
    }

    /**
     * Add actor
     *
     * @param \AppBundle\Entity\Actor $actor
     *
     * @return Film
     */
    public function addActor(\AppBundle\Entity\Actor $actor)
    {
        $this->actors[] = $actor;

        return $this;
    }

    /**
     * Remove actor
     *
     * @param \AppBundle\Entity\Actor $actor
     */
    public function removeActor(\AppBundle\Entity\Actor $actor)
    {
        $this->actors->removeElement($actor);
    }

    /**
     * Get actors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActors()
    {
        return $this->actors;
    }

    /**
     * Add userListWatchLater
     *
     * @param \AppBundle\Entity\User $userListWatchLater
     *
     * @return Film
     */
    public function addUserListWatchLater(\AppBundle\Entity\User $userListWatchLater)
    {
        $this->userListWatchLater[] = $userListWatchLater;

        return $this;
    }

    /**
     * Remove userListWatchLater
     *
     * @param \AppBundle\Entity\User $userListWatchLater
     */
    public function removeUserListWatchLater(\AppBundle\Entity\User $userListWatchLater)
    {
        $this->userListWatchLater->removeElement($userListWatchLater);
    }

    /**
     * Get userListWatchLater
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserListWatchLater()
    {
        return $this->userListWatchLater;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\comment $comment
     *
     * @return Film
     */
    public function addComment(\AppBundle\Entity\comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\comment $comment
     */
    public function removeComment(\AppBundle\Entity\comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
