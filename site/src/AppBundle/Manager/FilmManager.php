<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Actor;
use AppBundle\Entity\Category;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Film;
use AppBundle\Entity\Producer;
use AppBundle\Entity\Saga;
use AppBundle\Entity\User;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\EntityManagerInterface;


/**
 * Created by PhpStorm.
 * User: all
 * Date: 26/02/18
 * Time: 15:11
 */

class FilmManager
{
    private $em;
    private $filmRepository; 
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->filmRepository = $entityManager->getRepository(Film::class);
    }

    /**
     * @param $name
     * @param $description
     * @param $link
     * @param $image
     * @param $releaseAt
     * @param $saga
     * @param $actors
     * @param $producers
     * @param $categories
     */
    public function importFilm($name , $description , $link , $image , $releaseAt , $saga , $actors , $producers , $categories)
    {
                
        $film = $this->filmRepository->findOneByName($name);
        
        if(empty($film))
        {
            $dateNow = new DateTime();

            $newFilm = new Film();
            $newFilm->setName($name);
            $newFilm->setDescription($description);
            $newFilm->setLink($link);
            $newFilm->setImage($image);
            //$newFilm->setReleaseAt($releaseAt);
            $newFilm->setSaga($saga);
            
            foreach($actors as $actor)
            {
                $newFilm->addActor($actor);
            }
            
            foreach($producers as $producer)
            {
                $newFilm->addProducer($producer);
            }
            
            foreach($categories as $category)
            {
                $newFilm->addCategory($category);
            }
            
            $this->em->persist($newFilm);
            $this->em->flush();
            
        }
    }

    /**
     *
     * @param $page
     * @param $nbPerPage
     * @return array
     */
    public function getAllFilms(int $page,int $nbPerPage)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        $listFilm = $this->em->getRepository(Film::class)
            ->getAllFilm($page, $nbPerPage);

        $nbPages = ceil(count($listFilm) / $nbPerPage);

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        return [$listFilm, $nbPages];
    }

    /**
     * @param int $id
     * @return Film
     */
    public function getFilmById(int $id) : ?Film{
        return $this->em->getRepository(Film::class)
            ->findOneById($id);
    }

    /**
     * To add Film
     * @param $film
     * @return bool
     * @internal param string $name
     * @internal param string $description
     * @internal param string $link
     * @internal param string $image
     * @internal param bool $isSelected
     * @internal param \DateTime $releaseAt
     */
    public function addFilm($film)
    {
        $this->em->persist($film);
        $this->em->flush();
        return true;
    }

    /**
     * @internal param Film $film
     */
    public function editFilm($film)
    {
        $this->em->flush();
    }

    /**
     * @return array
     */
    public function getFilms()
    {
     
        $allFilms = $this->filmRepository->findAll();
        return $allFilms;
        
    }

    /**
     * @return array
     */
    public function getFilmSelected() : array{
        return $this->em->getRepository(Film::class)
            ->findByIsSelected(true);
    }

    /**
     * @param $film
     */
    public function deleteFilm($film)
    {
        
        $this->em->remove($film);
        $this->em->flush();
    }

    /**
     * @param $film
     */
    public function notSelectedFilm($film)
    {
        $film->setIsSelected(0);
        $this->em->persist($film);
        $this->em->flush();
    }

    /**
     * @param $film
     */
    public function isSelectedFilm($film)
    {
        $film->setIsSelected(1);
        $this->em->persist($film);
        $this->em->flush();
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
     * @param int $note
     * @return array
     */
    public function getFilmByRate(int $note) : array {
        $films = $this->getAllFilms();

        $goodRateFilm = [];
        foreach ($films as $film){
            if ($this->getRateByFilm($film) > $note)
            {
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
            ['createdAt'=>'DESC'] , 9
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
  
  /**
     * @param string $search
     * @return array
     */
    public function searchFilm(string $search) : array{
        //dump($search);
        $films = $this->filmRepository->searchFilm($search);
        return $films;
    }

    /**
     * @param User $user
     * @param Film $film
     * @return bool
     */
    public function getFilmHeartByUser(User $user,Film $film) :bool
    {
        /* @var \AppBundle\Entity\Film $filmHeart*/
        foreach ($user->getListFilmHeartStroke()->getValues() as $filmHeart){
            if ($filmHeart->getId() === $film->getId()){
                return true;
            }
        }
        return false;
    }

    /**
     * @param User $user
     * @param Film $film
     * @return bool
     */
    public function getFilmWatchLaterByUser(User $user,Film $film) :bool
    {
        /* @var \AppBundle\Entity\Film $filmLater*/
        foreach ($user->getListFilmWatchLater() as $filmLater){
            if ($filmLater->getId() === $film->getId()){
                return true;
            }
        }
        return false;
    }

    /**
     * @param Film $film
     * @param User $user
     * @return bool
     */
    public function addFilmHeart(Film $film, User $user) :bool
    {
        $user->addListFilmHeartStroke($film);
        $this->em->persist($user);
        $this->em->flush();

        return true;
    }

    /**
     * @param Film $film
     * @param User $user
     * @return bool
     */
    public function removeFilmHeart(Film $film, User $user) :bool
    {
        $user->removeListFilmHeartStroke($film);
        $this->em->persist($user);
        $this->em->flush();

        return true;
    }

    /**
     * @param Film $film
     * @param User $user
     * @return bool
     */
    public function addFilmWatch(Film $film, User $user) :bool
    {
        $user->addListFilmWatchLater($film);
        $this->em->persist($user);
        $this->em->flush();

        return true;
    }

    /**
     * @param Film $film
     * @param User $user
     * @return bool
     */
    public function removeFilmWatch(Film $film, User $user) :bool
    {
        $user->removeListFilmWatchLater($film);
        $this->em->persist($user);
        $this->em->flush();

        return true;
    }
  
  /**
     * @param array $comment
     * @param Film $film
     * @return int
     */
    public function getRateByFilm(Film $film) : ?int
    {
        $comments = $film->getComments();
            $rate = 0;
            foreach ($comments as $comment){
                $rate += $comment->getNote();
            }
            if(count($comments) == 0){
                return null;
            }
            else{
                return round($rate / count($comments),1);
            }

    }

    /**
     * @param $filmName
     * @return array|null
     */
    public function getFilmByFirstLetter($filmName) :?array
    {
        if (strlen($filmName) < 3){
            return null;
        }
        $query = $this->em->createQueryBuilder()
            ->select('f')
            ->from(Film::class, 'f')
            ->where('f.name LIKE :name')
            ->setParameter('name', $filmName.'%')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;

        return $query;
    }
}
