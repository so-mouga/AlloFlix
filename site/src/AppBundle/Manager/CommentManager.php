<?php
/**
 * Created by PhpStorm.
 * User: quach
 * Date: 27/02/18
 * Time: 11:36
 */

namespace AppBundle\Manager;


use AppBundle\Entity\Comment;
use AppBundle\Entity\Film;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CommentManager
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @return array
     */
    public function getAllComments() : array {
        return $this->em->getRepository(Comment::class)
            ->findAll();
    }

    /**
     * @param int $id
     * @return Comment
     */
    public function getCommentById(int $id) : ?Comment{
        return $this->em->getRepository(Comment::class)
            ->findById($id);
    }


    /**
     * @param string $description
     * @param int $note
     * @param User $user
     * @param Film $film
     * @return bool
     */
    public function addComment(string $description, int $note, User $user, Film $film) : bool{
        $comment = new Comment();
        $comment->setDescription($description)
            ->setNote($note)
            ->setUser($user)
            ->setFilm($film);

        $this->em->persist($comment);
        $this->em->flush();
        return true;
    }
}
