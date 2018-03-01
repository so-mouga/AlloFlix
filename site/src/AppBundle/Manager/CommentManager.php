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
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * notes commentary
     * @var array
     */
    const NOTES = [1,2,3,4,5,6,7,8,9,10];

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
     * @param Comment $comment
     * @return Comment|null
     */
    public function addComment(Comment $comment) : ?Comment
    {
        $this->em->persist($comment);
        $this->em->flush();

        return $comment;
    }

    /**
     * @param Film $film
     * @param User $user
     * @return Comment|null
     */
    public function getCommentByUser(Film $film, User $user) : ?Comment
    {
        $commentUser = null;
        foreach ($user->getComments() as $comment){
            if ($comment->getFilm()->getId() === $film->getId()){
                $commentUser = $comment;
                break;
            }
        }
        return $commentUser;
    }
}
