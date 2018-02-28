<?php 

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Saga;

class SagaManager
{
    
    private $em;
    private $sagaRepository;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->sagaRepository = $entityManager->getRepository(Saga::class);
    }
    
    
    public function findSagaByLabel($nameSaga)
    {
        
        
            $saga = $this->sagaRepository->findOneByLabel($nameSaga);
            
            if(empty($saga))
            {
                $newSaga = new Saga();
                $newSaga->setLabel($nameSaga);
                $this->em->persist($newSaga);
                $this->em->flush();
                
                return $newSaga;
                
            }
            else 
            {
                return $saga;
            }
            
            
            
    }
    
    
}


?>