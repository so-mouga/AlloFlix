<?php
/**
 * Created by PhpStorm.
 * User: nasri
 * Date: 27/02/2018
 * Time: 11:59
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $users = [
            [
                'pseudo' =>  'Kevin',
                'email'     =>  'Kevin@gmail.com',
                'role'     =>  ['ROLE_USER'],
            ],
            [
                'pseudo' =>  'Lucille',
                'email'     =>  'Lucille@gmail.com',
                'role'     =>  ['ROLE_USER'],
            ],
            [
                'pseudo' =>  'Nasser',
                'email'     =>  'Nasser@gmail.com',
                'role'     =>  ['ROLE_USER'],
            ],
            [
                'pseudo' =>  'Paul',
                'email'     =>  'Paul@gmail.com',
                'role'     =>  ['ROLE_ADMIN'],
            ],
        ];

        $i = 1;
        $a = 4;
        foreach ($users as $oneUser){

            $user = new User();
            $user->setPseudo($oneUser['pseudo']);
            $user->setRoles($oneUser['role']);
            $user->setEmail($oneUser['email']);
            $user->setIsBanished(false);
            $user->setPassword('$2y$13$veABY6kpgcaeZX1QO36AGeyAPzd0NeMrqU/Xo6qDeeDtxtJzW21u6');

            $user->addListFilmWatchLater($this->getReference('Film N°'.$i));
            $user->addListFilmHeartStroke($this->getReference('Film N°'.$a));

            $this->addReference('User N°'.$i, $user);
            $i++; $a++;
            $manager->persist($user);
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
