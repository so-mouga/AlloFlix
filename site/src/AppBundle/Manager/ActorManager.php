<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Actor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

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
        $i = 0;
        
        foreach($nameActors as $nameActor)
        {
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

    /**
     * @param Request $request
     * @param Actor $actor
     */
    public function editActor(Request $request , Actor $actor)
    {
        if (null != $request->request->get('appbundle_actor')['id'])
        {
            $data = $request->request->get('appbundle_actor');
            $actor = $this->getActorById($data['id']);
            $actor->setFullName($data['fullName']);
            $actor->setDescription($data['description']);
            $actor->setImage($data['image']);
            $request->getSession()->getFlashBag()->add('info', 'well edited actor.');
        }else {
            $this->em->persist($actor);
            $request->getSession()->getFlashBag()->add('info', 'well recorded actor.');
        }
        $this->em->flush();

    }

    /**
     * @param int $id
     */
    public function deleteActor(int $id)
    {
        $actor = $this->getActorById($id);

        if (null === $actor) {
            throw new NotFoundHttpException("L'actor d'id ".$id." n'existe pas.");
        }
        $this->em->remove($actor);
        $this->em->flush();
    }
}



