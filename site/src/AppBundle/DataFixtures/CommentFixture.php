<?php
/**
 * Created by PhpStorm.
 * User: nasri
 * Date: 23/02/2018
 * Time: 16:35
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixture extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 3; $i++)
        {
            $comment = new Comment();
            $comment->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                                        A animi cupiditate deserunt distinctio enim error,
                                        fugit harum impedit incidunt iste magni maiores maxime 
                                        natus nobis optio sed tempore voluptatum. Accusantium?');
            $comment->setNote(6);
            $comment->setFilm($this->getReference("Film N°".$i));
            $comment->setUser($this->getReference('User N°'.$i));
            $manager->persist($comment);
            $this->addReference('Comment N°'.$i, $comment);
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
            FilmFixture::class,
            UserFixture::class
        ];
    }
}