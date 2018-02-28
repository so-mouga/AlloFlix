<?php
/**
 * Created by PhpStorm.
 * User: nasri
 * Date: 26/02/2018
 * Time: 16:03
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ActorFixture extends Fixture
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
            $actor = new Actor();
            $actor->setFullName("Personnage N°".$i);
            $actor->setDescription("lorem ipsum");
            $actor->setImage("#");
            $this->addReference("Actor N°".$i, $actor);


            $manager->persist($actor);
        }
        $manager->flush();
    }

}