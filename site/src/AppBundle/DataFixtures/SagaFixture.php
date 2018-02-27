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
        for ($i = 1; $i <= 2; $i++)
        {
            $sage = new Saga();
            $sage->setLabel("sage N°".$i);

            $this->addReference('Saga N°'.$i, $sage);
            $manager->persist($sage);
        }

    $manager->flush();
    }

}