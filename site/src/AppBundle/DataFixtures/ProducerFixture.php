<?php
/**
 * Created by PhpStorm.
 * User: nasri
 * Date: 26/02/2018
 * Time: 16:14
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Producer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProducerFixture extends Fixture
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
            $producer = new Producer();
            $producer->setFullName("Personne N°".$i);
            $producer->setDescription("Lorem ipsum");

            $producer->setImage("#");
            $manager->persist($producer);
            $this->addReference('Producer N°'.$i, $producer);
        }
        $manager->flush();
    }

}