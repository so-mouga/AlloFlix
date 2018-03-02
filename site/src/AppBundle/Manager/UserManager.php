<?php
/**
 * Created by PhpStorm.
 * User: kevinmouga
 * Date: 26/02/2018
 * Time: 20:43
 */

namespace AppBundle\Manager;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    private $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(EntityManagerInterface $entityManager ,UserPasswordEncoderInterface $encoder)
    {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
        $this->userRepository = $entityManager->getRepository(User::class);
    }

    /**
     * @param User $user
     */
    public function addUser(User $user) :User
    {
        $user->setRoles(['ROLE_USER']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @return array
     */
    public function getAllUsers() :array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }
    
    public function getUserById($idUser)
    {
        $user = $this->userRepository->findOneById($idUser);
        return $user;
        
    }
    
    public function banUser($user)
    {
        $user->setIsBanished(1);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
    
    public function unBanUser($user)
    {
        $user->setIsBanished(0);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
    
    /**
     * @return array
     */
    public function getAllUsersNotBanned() :array
    {
        return $this->entityManager->getRepository(User::class)->getIsBanished(0);
    }

    /**
     * @param String $pseudo
     * @return object
     */
    public function getUserByPseudo(String $pseudo)
    {
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['pseudo' => $pseudo]);

        return $user;
    }

    /**
     * @return array
     */
    public function getUsersBanned() :array
    {
        $list = $this->userRepository->findByIsBanished(1);
          
        return $list;
    }

    /**
     * @param string $pseudo
     * @param string $email
     * @param string $password
     */
    public function setUserAdmin(string $pseudo, string $email, string $password)
    {
        $user = new User();
        $password = $this->encoder->encodePassword($user, $password);
        $user->setPseudo($pseudo)
            ->setEmail($email)
            ->setPassword($password)
            ->setRoles(['ROLE_ADMIN']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param string $pseudo
     * @param string $email
     * @param string $password
     */
    public function setUser(string $pseudo, string $email, string $password) :User
    {
        $user = new User();
        $password = $this->encoder->encodePassword($user, $password);
        $user->setPseudo($pseudo)
            ->setEmail($email)
            ->setPassword($password)
            ->setRoles(['ROLE_USER']);

        return $user;

    }

    /**
     * @param string $search
     * @return array
     */
    public function searchUser(string $search) : array
    {
        $actors = $this->userRepository->searchUser($search);
        return $actors;
    }

    /**
     * encode password user in bcryp
     *
     * @param User $user
     */
    public function encodePasswordUser(User $user)
    {
        $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
    }

    /**
     * @param User $user
     * @return User
     */
    public function createUser(User $user) :User
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
