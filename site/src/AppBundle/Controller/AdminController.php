<?php
/**
 * Created by PhpStorm.
 * User: kevinmouga
 * Date: 26/02/2018
 * Time: 16:33
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Film;
use AppBundle\Form\FilmType;
use AppBundle\Manager\ActorManager;
use AppBundle\Entity\Actor;
use AppBundle\Form\ActorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(ActorManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/films", name="admin_films")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminFilmsAction(Request $request)
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class);

        if ($request->isMethod('POST') AND  $form->handleRequest($request)->isValid()){
            dump($form->getData());
            exit;
            $this->entityManager->persist($film);
            $this->entityManager->flush();

            $request->getSession()->getFlashBag()
                ->add('info', 'Le film à bien été ajouté.');
        }

        return $this->render('admin/admin_films.html.twig',[
            'form'  =>  $form->createView(),
        ]);
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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createActorAction(Request $request)
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
                $this->manager->editActor($request, $actor);
        }

        return $this->render('admin/admin_actor.html.twig', array(
            'form' => $form->createView(),
            'listActor' => $this->manager->getAllActors()
        ));
    }

    /**
     * @Route("/admin/actor/delete/{id_delete}", name="delete_actor")
     * @param int $id_delete
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @internal param $id
     */
    public function deleteAction(int $id_delete, Request $request)
    {
       $this->manager->deleteActor($id_delete);
        $request->getSession()->getFlashBag()->add('info', "L'actor a bien été supprimée.");
        return $this->redirectToRoute('create_actor');
    }
}
