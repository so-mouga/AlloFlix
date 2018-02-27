<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = array();

    /**
     * @var string
     *
     * @ORM\Column(name="Pseudo", type="string", length=255, unique=true)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=255)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CreatedAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="isBanished", type="boolean", nullable=true)
     */
    private $isBanished = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateBanishment", type="datetime", nullable=true)
     */
    private $dateBanishment;

    /**
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Film", cascade={"persist"})
     * @ORM\JoinTable(name="listWatchLaterUser")
     */
    private $listFilmWatchLater;

    /**
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Film", cascade={"persist"})
     * @ORM\JoinTable(name="listHeartStrokeUser")
     * 
     */
    private $listFilmHeartStroke;
    
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="user")
     */
    private $comments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->listFilmWatchLater = new \Doctrine\Common\Collections\ArrayCollection();
        $this->listFilmHeartStroke = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \Datetime();
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
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return User
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
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
     * Set isBanished
     *
     * @param boolean $isBanished
     *
     * @return User
     */
    public function setIsBanished($isBanished)
    {
        $this->isBanished = $isBanished;

        return $this;
    }

    /**
     * Get isBanished
     *
     * @return bool
     */
    public function getIsBanished()
    {
        return $this->isBanished;
    }

    /**
     * Set dateBanishment
     *
     * @param \DateTime $dateBanishment
     *
     * @return User
     */
    public function setDateBanishment($dateBanishment)
    {
        $this->dateBanishment = $dateBanishment;

        return $this;
    }

    /**
     * Get dateBanishment
     *
     * @return \DateTime
     */
    public function getDateBanishment()
    {
        return $this->dateBanishment;
    }

    public function eraseCredentials()
    {
        return;
    }

    /**
     * @return null|string
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->pseudo;
    }


    /**
     * Add listFilmWatchLater
     *
     * @param Film $listFilmWatchLater
     *
     * @return User
     */
    public function addListFilmWatchLater(Film $listFilmWatchLater)
    {
        $this->listFilmWatchLater[] = $listFilmWatchLater;

        return $this;
    }

    /**
     * Remove listFilmWatchLater
     *
     * @param Film $listFilmWatchLater
     */
    public function removeListFilmWatchLater(Film $listFilmWatchLater)
    {
        $this->listFilmWatchLater->removeElement($listFilmWatchLater);
    }

    /**
     * Get listFilmWatchLater
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListFilmWatchLater()
    {
        return $this->listFilmWatchLater;
    }

    /**
     * Add listFilmHeartStroke
     *
     * @param Film $listFilmHeartStroke
     *
     * @return User
     */
    public function addListFilmHeartStroke(Film $listFilmHeartStroke)
    {
        $this->listFilmHeartStroke[] = $listFilmHeartStroke;

        return $this;
    }

    /**
     * Remove listFilmHeartStroke
     *
     * @param \AppBundle\Entity\Film $listFilmHeartStroke
     */
    public function removeListFilmHeartStroke(Film $listFilmHeartStroke)
    {
        $this->listFilmHeartStroke->removeElement($listFilmHeartStroke);
    }

    /**
     * Get listFilmHeartStroke
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListFilmHeartStroke()
    {
        return $this->listFilmHeartStroke;
    }

    /**
     * Add comment
     *
     * @param Comment $comment
     *
     * @return User
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
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
