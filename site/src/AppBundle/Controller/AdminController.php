<?php
/**
 * Created by PhpStorm.
 * User: kevinmouga
 * Date: 26/02/2018
 * Time: 16:33
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Actor;
use AppBundle\Form\ActorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/admin/films", name="admin_films")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminFilmsAction()
    {
        return $this->render('admin/admin_films.html.twig');
    }

    /**
     * @Route("/admin/users", name="admin_users")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminUsersAction()
    {
        return $this->render('admin/admin_users.html.twig');
    }

    /**
     * @Route("/admin/categories", name="admin_categories")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminCategoriesAction()
    {
        return $this->render('admin/admin_categories.html.twig');
    }

    /**
     * @Route("/admin/actor", name="create_actor")
     */
    public function createActorAction(Request $request)
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($actor);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'well recorded actor.');
        }

        return $this->render('admin/admin_actor.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}