<?php
/**
 * Created by PhpStorm.
 * User: kevinmouga
 * Date: 26/02/2018
 * Time: 16:33
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Film;
use AppBundle\Entity\User;
use AppBundle\Form\FilmType;
use AppBundle\Manager\ActorManager;
use AppBundle\Entity\Actor;
use AppBundle\Form\ActorType;
use AppBundle\Manager\FilmManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Manager\UserManager;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\UserType;

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
    public function adminFilmsAction(Request $request , FilmManager $filmManager)
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class , $film);
        
        $listFilms = $filmManager->getFilms();
        $listFilmsSelected = $filmManager->getFilmSelected();
        
        if ($request->isMethod('POST') AND  $form->handleRequest($request)->isValid()){
            $filmManager->addFilm($film);
   

            $request->getSession()->getFlashBag()
                ->add('info', 'Le film à bien été ajouté.');
        }

        return $this->render('admin/admin_films.html.twig',[
            'form'  =>  $form->createView(), "listFilms" => $listFilms , "listFilmsSelected" => $listFilmsSelected
        ]);
    }

    /**
     * @Route("/admin/users", name="admin_users")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminUsersAction(Request $request , UserManager $userManager)
    {
        $listUsersBanned = $userManager->getUsersBanned();
        $listUsers = $userManager->getAllUsersNotBanned();
        
        $user = new User();
        $form = $this->createForm(UserType::class , $user);
        $form->handleRequest($request);
       
        
        if($form->isValid())
        {
            $userManager->addUser($user);
        }
        
        return $this->render('admin/admin_users.html.twig' , array("form" => $form->createView() , "listUsersBanned" => $listUsersBanned , "listUsers" => $listUsers));
    }

    /**
     * @Route("/admin/unban/{idUser}", name="unban")
     *
     */
    public function adminUnbanAction(UserManager $userManager , $idUser)
    {
        $user = $userManager->getUserById($idUser);
        $userManager->unBanUser($user);
//         return new Response("Débannir !");
        return $this->redirectToRoute('admin_users');
//         return $this->render('admin/admin_categories.html.twig');
    }
    
    /**
     * @Route("/admin/modificationFilm/{idFilm}", name="modificationFilm")
     *
     */
    public function adminModifFilmAction(FilmManager $filmManager , $idFilm)
    {
       
        return $this->redirectToRoute('admin_films');
    }
    
    /**
     * @Route("/admin/deleteFilm/{idFilm}", name="deleteFilm")
     *
     */
    public function adminDeleteFilmAction(FilmManager $filmManager , $idFilm)
    {
        $film = $filmManager->getFilmById($idFilm);
       
        $filmManager->deleteFilm($film);
        
        return $this->redirectToRoute('admin_films');
        //         return $this->render('admin/admin_categories.html.twig');
    }
    
    /**
     * @Route("/admin/notSelectedFilm/{idFilm}", name="notSelectedFilm")
     *
     */
    public function adminNotSelectedFilmAction(FilmManager $filmManager , $idFilm)
    {
        $film = $filmManager->getFilmById($idFilm);
        $filmManager->notSelectedFilm($film);
        return $this->redirectToRoute('admin_films');
        
    }
    
    /**
     * @Route("/admin/isSelectedFilm/{idFilm}", name="isSelectedFilm")
     *
     */
    public function adminIsSelectedFilmAction(FilmManager $filmManager , $idFilm)
    {
        $film = $filmManager->getFilmById($idFilm);
        $filmManager->isSelectedFilm($film);
        return $this->redirectToRoute('admin_films');
        
    }
    
    
    /**
     * @Route("/admin/ban/{idUser}", name="ban")
     *
     */
    public function adminBanAction(UserManager $userManager , $idUser)
    {
        
        $user = $userManager->getUserById($idUser);
        $userManager->banUser($user);
//         return new Response("Bannir !");
        return $this->redirectToRoute('admin_users');
      
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
            $em = $this->getDoctrine()->getManager();
            if (null != $request->request->get('appbundle_actor')['id'])
            {
                $data = $request->request->get('appbundle_actor');
                $this->manager->editActor($data);
                $request->getSession()->getFlashBag()->add('info', 'well edited actor.');
            }else {
                $em->persist($actor);
                $request->getSession()->getFlashBag()->add('info', 'well recorded actor.');
            }
            $em->flush();

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
