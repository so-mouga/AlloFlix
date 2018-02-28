<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Actor;
use AppBundle\Entity\Category;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Film;
use AppBundle\Entity\Producer;
use AppBundle\Entity\Saga;
use Symfony\Component\Validator\Constraints\DateTime;

use Doctrine\ORM\EntityManagerInterface;


/**
 * Created by PhpStorm.
 * User: quach
 * Date: 26/02/18
 * Time: 15:11
 */

class FilmManager
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     *
     * @return array
     */
    public function getAllFilms() {
        return $this->em->getRepository(Film::class)
            ->findAll();
    }

    /**
     * @param int $id
     * @return Film
     */
    public function getFilmById(int $id) : Film{
        return $this->em->getRepository(Film::class)
            ->findOneById($id);
    }

    /**
     * To add Film
     * @param string $name
     * @param string $description
     * @param string $link
     * @param string $image
     * @param bool $isSelected
     * @param \DateTime $releaseAt
     * @return bool
     */
    public function addFilm(string $name, string $description, string $link, string $image, bool $isSelected, \DateTime $releaseAt) :bool{
        $film = new Film();
        $film->setName($name)
            ->setDescription($description)
            ->setLink($link)
            ->setImage($image)
            ->setIsSelected($isSelected)
            ->setReleaseAt($releaseAt);
        $this->em->persist($film);
        $this->em->flush();
        return true;
    }

    /**
     * @return array
     */
    public function getFilmSelected() : array{
        return $this->em->getRepository(Film::class)
            ->findByIsSelected(true);
    }

    /**
     * @param string $name
     * @return array
     */
    public function getFilmByName(string $name) : array{
        return $this->em->getRepository(Film::class)
            ->findByName($name);
    }


    /**
     * @param array $comment
     * @param Film $film
     * @return int
     */
    public function getRateByFilm(Film $film) : int{

        $comments = $film->getComments();
            $rate = 0;
            foreach ($comments as $comment){
                $rate += $comment->getNote();
            }
            if(count($comments) == 0){
                return 0;
            }
            else{
                return round($rate / count($comments),1);
            }

    }

    /**
     * @param int $note
     * @return array
     */
    public function getFilmByRate(int $note) : array {
        $films = $this->getAllFilms();

        $goodRateFilm = [];
        foreach ($films as $film){
            //dump($film);
            if($this->getRateByFilm($film) > $note){
                array_push($goodRateFilm,$film);
            }
        }
        return $goodRateFilm;
    }

    /**
     * @return array
     */
    public function getFilmByCreatedAt() : array{
        $films = $this->em->getRepository(Film::class)->findBy(
            [],
            ['createdAt'=>'DESC']
        );
        /*$query = $this->em->createQueryBuilder()
            ->select('f')
            ->from(Film::class, 'f')
            ->orderBy('f.createAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;

        return $query;*/
        return $films;
    }
}