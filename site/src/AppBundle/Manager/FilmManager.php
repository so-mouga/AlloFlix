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
    
    public function importFilm($name , $description , $link , $image , $releaseAt , $saga , $actors , $producers , $categories)
    {
                
        $film = $this->filmRepository->findOneByName($name);
        
        if(empty($film))
        {
         
//             $serializer = new Serializer(array(new DateTimeNormalizer()));
            
//             $dateAsString = $serializer->normalize(new \DateTime());
//             $dateRelease = new DateTime();
//             //$dateRelease = $date->format('d-m-Y');
// //             dump($dateRelease);
// //             die();

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

    public function getAllFilmsByCategory(int $page,int $nbPerPage)
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
     * @param string $name
     * @param string $description
     * @param string $link
     * @param string $image
     * @param bool $isSelected
     * @param \DateTime $releaseAt
     * @return bool
     */
    public function addFilm($film)
    {
        $this->em->persist($film);
        $this->em->flush();
        return true;
    }
    
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
    
    
    public function deleteFilm($film)
    {
        $this->em->remove($film);
        $this->em->flush();
    }
    
    public function notSelectedFilm($film)
    {
        $film->setIsSelected(0);
        $this->em->persist($film);
        $this->em->flush();
    }
    
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
     * @param $films
     * @return array
     */
    public function getFilmByRate(int $note, $films) : array {

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
    
    public function getListFilmByCategOrNote(?Category $category, ?int $note){

        if($category == null && $note == 0){
            return $this->em->getRepository(Film::class)
                ->findAll();
        }
        elseif ($category == null && $note != 0){

            $films = $this->em->getRepository(Film::class)
                ->findAll();
            return $this->getFilmByRate($note,$films);
        }
        else{
            $films = $category->getFilms();
            if($note == 0){
                return $films;
            }
            else{
                return $this->getFilmByRate($note,$films);
            }
        }
    }
}
