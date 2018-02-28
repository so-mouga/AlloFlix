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
            $film->setImage('http://thebabuzz.com/wp-content/uploads/2017/09/spider-man-homecoming-banner.jpg');
            $film->setIsSelected(false);

            $film->setLink("#");
            for ($a = 1; $a <= 2; $a++)
            {
                $film->addActor($this->getReference('Actor N°'.$a));
            }
            if ($i <= 4)
            {
                $film->addCategory($this->getReference('Category N°0'));
            }elseif ($i <= 7)
            {
               $film->addCategory($this->getReference('Category N°1'));
            }else
            {
                $film->addCategory($this->getReference('Category N°2'));
            }

            if($i < 5)
            {
                $film->addProducer($this->getReference("Producer N°1"));
            }else{
                $film->addProducer($this->getReference("Producer N°2"));
            }

            $film->setLink("https://www.youtube.com/embed/mJQ4u-kXoGc");


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
            ProducerFixture::class,
            CategoryFixture::class,
            SagaFixture::class,
            ActorFixture::class
        ];
    }
}
