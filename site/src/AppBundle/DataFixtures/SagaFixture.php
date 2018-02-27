<?php
/**
 * Created by PhpStorm.
 * User: nasri
 * Date: 26/02/2018
 * Time: 15:48
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Saga;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SagaFixture extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $dif = true;
        for ($i = 1; $i <= 2; $i++)
        {
            $sage = new Saga();
            $sage->setLabel("sage N°".$i);


//            if ($dif == true)
//            {
//                for ($a = 1; $a <= 5; $a++)
//                {
//                    $sage->addFilm($this->getReference('Film N°'.$a));
//                }
//                $dif = false;
//            }else{
//                for ($a = 5; $a <= 10; $a++)
//                {
//                    $sage->addFilm($this->getReference('Film N°'.$a));
//                }
//            }
            $this->addReference('Saga N°'.$i, $sage);
            $manager->persist($sage);
        }

    $manager->flush();
    }

}