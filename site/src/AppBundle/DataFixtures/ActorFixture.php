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
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ActorFixture extends Fixture implements DependentFixtureInterface
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
            $actor->setFirstName("Personnage N°".$i);
            $actor->setLastName("Actor N°".$i);
            $actor->setDescription("lorem ipsum");
            $actor->setImage("#");
            if ($i == 1)
            {
                for ($a = 1; $a <= 5; $a++)
                {
                    $actor->addFilm($this->getReference("Film N°".$a));
                }
            }
            else{
                for ($a = 6; $a <= 10; $a++)
                {
                    $actor->addFilm($this->getReference("Film N°".$a));
                }
            }


            $manager->persist($actor);
        }
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    function getDependencies()
    {
        return [
            FilmFixture::class
        ];
    }
}