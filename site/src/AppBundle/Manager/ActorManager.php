<?php 

namespace AppBundle\Manager;

use AppBundle\Entity\Actor;
use Doctrine\ORM\EntityManagerInterface;

class ActorManager
{
    
    private $em;
    private $actorRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->actorRepository = $entityManager->getRepository(Actor::class);
    }
    
    
    public function addActor($fullName , $description , $image)
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
    
    public function findActorByName($actorsName)
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
                $newActor->setFullName($nameActor);
                $newActor->setDescription("iojiojijo");
                $newActor->setImage("vdd");
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
    
    
}


?>