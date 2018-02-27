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
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProducerFixture extends Fixture implements DependentFixtureInterface
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
            $producer->setFirstName("Personne N°".$i);
            $producer->setLastName("Producer N°".$i);
            $producer->setDescription("Lorem ipsum");
            if ($i == 1)
            {
                for ($a = 1; $a <= 5; $a++)
                {
                    $producer->addFilm($this->getReference("Film N°".$a));
                }
            }
            else{
                for ($a = 6; $a <= 10; $a++)
                {
                    $producer->addFilm($this->getReference("Film N°".$a));
                }
            }
            $producer->setImage("#");
            $manager->persist($producer);
            $this->addReference('Producer N°'.$i, $producer);
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