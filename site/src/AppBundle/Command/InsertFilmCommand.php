<?php

namespace AppBundle\Command;


use AppBundle\Entity\Producer;
use AppBundle\Manager\ActorManager;
use AppBundle\Manager\CategoryManager;
use AppBundle\Manager\ProducerManager;
use AppBundle\Manager\SagaManager;
use AppBundle\Manager\FilmManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Validator\Constraints\DateTime;


class InsertFilmCommand extends ContainerAwareCommand
{
   
    private $filmManager;
    private $actorManager;
    private $producerManager;
    private $categoryManager;
    private $sagaManager;
    
    public function __construct(filmManager $filmManager , ActorManager $actorManager , ProducerManager $producerManager
        , CategoryManager $categoryManager , SagaManager $sagaManager)
    {
        
        $this->actorManager = $actorManager;
        $this->categoryManager = $categoryManager;
        $this->filmManager = $filmManager;
        $this->sagaManager = $sagaManager;
        $this->producerManager = $producerManager;
        
        parent::__construct();
    }
    
    protected function configure()
    {
        $this->setName('ImportCSV')
        ->setDescription('Injection film , actor , productor');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
              
        $pathActor = 'web/Csv/actor.csv';
        $pathProducer = 'web/Csv/producer.csv';
        $pathFilm = 'web/Csv/film.csv';
        
        
        if (($handle = fopen($pathActor, "r")) !== false) {
            $cpt = 0;
            while (($data = fgetcsv($handle, 0, ";")) !== false) {
                //echo $data[0];
                if($cpt != 0)
                {
                    
                    $fullName = $data[0];
                    $description = $data[1];
                    $image = $data[2];
                    $actor = $this->actorManager->importActor($fullName, $description , $image);
                }
                $cpt ++;
            }
        }
        echo "Actor Import !";
        if (($handle = fopen($pathProducer, "r")) !== false) {
            $cpt = 0;
            
            while (($data = fgetcsv($handle, 0, ";")) !== false) {
                if($cpt != 0)
                {
                    $fullName = $data[0];
                    $description = $data[1];
                    $image = $data[2];
                    $productor = $this->producerManager->importProducer($fullName , $description , $image);
                }
                
                $cpt ++;
            }
        }
        echo "Producer Import !";
        if (($handle = fopen($pathFilm, "r")) !== false) {
            $cpt = 0;
            while (($data = fgetcsv($handle, 0, ";")) !== false) {
                if($cpt != 0)
                {
                    $name = $data[0];
                    $description = $data[1];                  
                    $link = $data[2];
                    $image = $data[3];
                    $releaseAt = $data[4];
                    $actorsName = $data[5];
                    $producersName = $data[6];
                    $categoriesName = $data[7];
                    $nameSaga = $data[8];
                    $actors = $this->actorManager->importActorByName($actorsName);
                    $producers = $this->producerManager->findProducerByName($producersName);
                    $categories = $this->categoryManager->findCategoriesByLabel($categoriesName);
                    $saga = $this->sagaManager->findSagaByLabel($nameSaga);
//                     $releaseAt = new DateTime();
                    $this->filmManager->importFilm($name , $description , $link , $image , $releaseAt , $saga , $actors , $producers , $categories);

                }
                $cpt ++;
            }
        }
        echo "Film Import !";
        $output->writeln("Import Complete !");
        
}
}
