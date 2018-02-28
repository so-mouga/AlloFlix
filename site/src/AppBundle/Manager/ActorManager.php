<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Actor;
use Doctrine\ORM\EntityManagerInterface;

class ActorManager
{
    
    private $em;
    private $actorRepository;

    /**
     * ActorManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->actorRepository = $entityManager->getRepository(Actor::class);
    }


    /**
     * @param $fullName
     * @param $description
     * @param $image
     */
    public function importActor($fullName , $description , $image)
    {
        $actor = $this->actorRepository->findOneByFullName($fullName);
        if(empty($actor))
        {
            $actor = new Actor();
            $actor->setFullName($fullName);
            $actor->setDescription($description);
            $actor->setImage($image);
            
            $this->em->persist($actor);
            $this->em->flush();
        }
    }

    /**
     * @param $actorsName
     * @return array
     */
    public function importActorByName($actorsName)
    {
        $nameActors = explode("," , $actorsName);
        $listActor = [];
        
        foreach($nameActors as $nameActor)
        {
            $i = 0;
            $actor = $this->actorRepository->findOneByFullName($nameActor);
            
            if(empty($actor))
            {
                $newActor = new Actor();
                $newActor->setFullName($nameActor)
                    ->setDescription("iojiojijo")
                    ->setImage("vdd");

                $this->em->persist($newActor);
                $this->em->flush();

                $listActor[$i] = $newActor;
            }
            else
            {
                $listActor[$i] = $actor;
                
            }
            $i++;
        }
        if(!empty($listActor))
        {
            return $listActor;
        }
    }

    /**
     * @return array
     */
    public function getAllActors() : array {
        return $this->em->getRepository(Actor::class)
            ->findAll();
    }

    /**
     * @param int $id
     * @return Actor
     */
    public function getActorById(int $id) : ?Actor{
        return $this->em->getRepository(Actor::class)
            ->findOneById($id);
    }

    /**
     * @param string $fullName
     * @return Actor
     */
    public function getActorByFullName(string $fullName) : ?Actor{
        return $this->em->getRepository(Actor::class)
            ->findOneByFullName($fullName);
    }

    /**
     * @param string $fullname
     * @param string $description
     * @param string $image
     * @return bool
     */
    public function addActor(string $fullname, string $description, string $image) : bool{
        $actor = new Actor();
        $actor->setFullName($fullname)
            ->setDescription($description)
            ->setImage($image);

        $this->em->persist($actor);
        $this->em->flush();
        return true;
    }
}



