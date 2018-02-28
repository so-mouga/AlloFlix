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
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixture extends Fixture
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

            $manager->persist($category);
            $this->addReference('Category N°'.$i, $category);
        }
        $manager->flush();
    }

}