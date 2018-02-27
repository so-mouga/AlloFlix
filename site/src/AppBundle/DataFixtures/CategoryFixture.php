<?php
/**
 * Created by PhpStorm.
 * User: nasri
 * Date: 26/02/2018
 * Time: 16:26
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixture extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $tab = array('Comedies','Anime','Action & Adventure');
        for ($i = 0; $i <= 2; $i++)
        {
            $category = new Category();
            $category->setLabel($tab[$i]);
            if ($i == 0)
            {
                for ($a = 1; $a <= 4; $a++)
                {
                    $category->addFilm($this->getReference('Film N°'.$a));
                }
            }elseif ($i == 1)
            {
                for ($a = 5; $a <= 7; $a++)
                {
                    $category->addFilm($this->getReference('Film N°'.$a));
                }
            }else
            {
                for ($a = 8; $a <= 10; $a++)
                {
                    $category->addFilm($this->getReference('Film N°'.$a));
                }
            }
            $manager->persist($category);
            $this->addReference('Category N°'.$i, $category);
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