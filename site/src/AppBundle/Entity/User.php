<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(name="Pseudo", type="string", length=255)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255)
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
     * @ORM\Column(name="isBanished", type="boolean")
     */
    private $isBanished;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateBanishment", type="datetime")
     */
    private $dateBanishment;

    /**
     * collection film for user
     * @var array
     */
    private $listHeartStroke;

    /**
     * collection film watch laser for user
     * @var array
     */
    private $listWatchLater;

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
}

