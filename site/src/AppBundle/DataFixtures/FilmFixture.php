<?php
/**
 * Created by PhpStorm.
 * User: nasri
 * Date: 26/02/2018
 * Time: 15:07
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Film;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class FilmFixture extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++)
        {
            $film = new Film();
            $film->setName('film N°'.$i);
            $film->setDescription('lorem ipsum film N°'.$i);
            $film->setImage('#');
            $film->setIsSelected(false);
            $film->setLink("#");

            if($i < 5)
            {
                $film->setSaga($this->getReference("Saga N°1"));
            }else{
                $film->setSaga($this->getReference("Saga N°2"));
            }
            $manager->persist($film);

            $this->addReference('Film N°'.$i, $film);
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
            SagaFixture::class
        ];
    }
}