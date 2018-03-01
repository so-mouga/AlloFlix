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

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    private $userRepository;

    public function __construct(EntityManagerInterface $entityManager ,UserPasswordEncoderInterface $encoder)
    {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
        $this->userRepository = $entityManager->getRepository(User::class);
    }

    /**
     * @return array
     */
    public function getAllUsers() :array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
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
        $query = $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.isBanished = :isBanished')
            ->setParameter('isBanished', 1)
            ->getQuery()
            ->getResult()
        ;
        return $query;
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
     * @param string $search
     * @return array
     */
    public function searchUser(string $search) : array{
        $actors = $this->userRepository->searchUser($search);
        return $actors;
    }
}
