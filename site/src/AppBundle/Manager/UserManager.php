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

class UserManager
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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

}
