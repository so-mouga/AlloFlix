<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Producer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProducerManager
{
    
    private $em;
    private $producerRepository;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->producerRepository = $entityManager->getRepository(Producer::class);
    }
    
    
    public function importProducer($fullName , $description , $image)
    {
        $producer = $this->producerRepository->findOneByFullName($fullName);
        if(empty($producer))
        {
            $producer = new Producer();
            $producer->setFullName($fullName);
            $producer->setDescription($description);
            $producer->setImage($image);
            
            $this->em->persist($producer);
            $this->em->flush();
        }
    }
    
    public function findProducerByName($producersName)
    {
        $nameProducers = explode("," , $producersName);
        $listProducer = [];
        $i = 0;
        
        foreach($nameProducers as $nameProducer)
        {
            $producer = $this->producerRepository->findOneByFullName($nameProducer);
            
            if(empty($producer))
            {
                $newProducer = new Producer();
                $newProducer->setFullName($nameProducer);
                $newProducer->setDescription("iojiojijo");
                $newProducer->setImage("vdd");
                $this->em->persist($newProducer);
                $this->em->flush();
                
                $listProducer[$i] = $newProducer;
            }
            else
            {
                $listProducer[$i] = $producer;
            }
            $i++;
        }
        if(!empty($listProducer))
        {
            return $listProducer;
        }
    }
    /**
     * @return array
     */
    public function getAllProducers() : array {
        return $this->em->getRepository(Producer::class)
            ->findAll();
    }

    /**
     * @param int $id
     * @return Producer
     */
    public function getProducerById(int $id) : ?Producer{
        return $this->em->getRepository(Producer::class)
            ->findOneById($id);
    }

    public function getProducerByName(string $fullName) : ?Producer {
        return $this->em->getRepository(Producer::class)
            ->findOneByFullName($fullName);
    }

    /**
     * @param string $fullname
     * @param string $description
     * @param string $image
     * @return bool
     */
    public function addProducer(string $fullname, string $description, string $image) : bool{
        $producer = new Producer();
        $producer->setFullName($fullname)
            ->setDescription($description)
            ->setImage($image);

        $this->em->persist($producer);
        $this->em->flush();
        return true;
    }

    public function createProducer(Request $request, Producer $producer)
    {
        if (null != $request->request->get('appbundle_producer')['id'])
        {
            $data = $request->request->get('appbundle_producer');
            $producer = $this->getProducerById($data['id']);
            $producer->setFullName($data['fullName']);
            $producer->setDescription($data['description']);
            $producer->setImage($data['image']);
            $request->getSession()->getFlashBag()->add('info', 'well edited actor.');
        }else {
            $this->em->persist($producer);
            $request->getSession()->getFlashBag()->add('info', 'well recorded actor.');
        }
        $this->em->flush();
    }


    /**
     * @param int $id
     */
    public function deleteProducer(int $id)
    {
        $actor = $this->getProducerById($id);

        if (null === $actor) {
            throw new NotFoundHttpException("Le Producer d'id ".$id." n'existe pas.");
        }
        $this->em->remove($actor);
        $this->em->flush();
    }
    
}
