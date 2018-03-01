<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Saga;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @return array
     */
    public function getAllSaga() : array {
        return $this->em->getRepository(Saga::class)
            ->findAll();
    }

    /**
     * @param int $id
     * @return Saga
     */
    public function getSagaById(int $id) : ?Saga{
        return $this->em->getRepository(Saga::class)
            ->findOneById($id);
    }


    /**
     * @param string $label
     * @return bool
     */
    public function addSaga(string $label) : bool{
        $saga = new Saga();
        $saga->setLabel($label);

        $this->em->persist($saga);
        $this->em->flush();
        return true;
    }

    /**
     * @param Request $request
     * @param Saga $saga
     */
    public function createSaga(Request $request, Saga $saga)
    {
        if (null != $request->request->get('appbundle_saga')['id'])
        {
            $data = $request->request->get('appbundle_saga');
            $saga = $this->getSagaById($data['id']);
            $saga->setLabel($data['label']);
            $request->getSession()->getFlashBag()->add('info', 'well edited category.');
        }else {
            $this->em->persist($saga);
            $request->getSession()->getFlashBag()->add('info', 'well recorded category.');
        }
        $this->em->flush();
    }

    /**
     * @param int $id
     */
    public function deleteSaga(int $id)
    {
        $saga = $this->getSagaById($id);

        if (null === $saga) {
            throw new NotFoundHttpException("saga d'id ".$id." n'existe pas.");
        }
        $this->em->remove($saga);
        $this->em->flush();
    }
}
