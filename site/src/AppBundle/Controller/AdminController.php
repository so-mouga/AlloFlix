<?php
/**
 * Created by PhpStorm.
 * User: kevinmouga
 * Date: 26/02/2018
 * Time: 16:33
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Film;
use AppBundle\Entity\Producer;
use AppBundle\Form\CategoryType;
use AppBundle\Form\FilmType;
use AppBundle\Form\ProducerType;
use AppBundle\Manager\ActorManager;
use AppBundle\Entity\Actor;
use AppBundle\Form\ActorType;
use AppBundle\Manager\CategoryManager;
use AppBundle\Manager\ProducerManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $actorManager;

    /**
     * @var ProducerManager
     */
    private $producerManager;

    private $categoryManager;

    /**
     * AdminController constructor.
     * @param ActorManager $actorManager
     * @param ProducerManager $producerManager
     * @param CategoryManager $categoryManager
     */
    public function __construct(ActorManager $actorManager,ProducerManager $producerManager,CategoryManager $categoryManager)
    {
        $this->actorManager = $actorManager;
        $this->producerManager = $producerManager;
        $this->categoryManager = $categoryManager;
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
                $this->actorManager->editActor($request, $actor);
        }

        return $this->render('admin/admin_actor.html.twig', array(
            'form' => $form->createView(),
            'listActor' => $this->actorManager->getAllActors()
        ));
    }

    /**
     * @Route("/admin/actor/delete/{id_delete}", name="delete_actor")
     * @param int $id_delete
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @internal param $id
     */
    public function deleteActorAction(int $id_delete, Request $request)
    {
        $submittedToken = $request->request->get('_csrf_token');

        if ($request->isMethod('POST') && $this->isCsrfTokenValid('delete-actor', $submittedToken))
        {
           $this->actorManager->deleteActor($id_delete);
            $request->getSession()->getFlashBag()->add('info', "L'actor a bien été supprimée.");
            return $this->redirectToRoute('create_actor');
        }
    }

    /**
     * @Route("/admin/producer", name="create_producer")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createProducerAction(Request $request)
    {
        $producer = new Producer();
        $form = $this->createForm(ProducerType::class, $producer);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $this->producerManager->createProducer($request, $producer);
        }

        return $this->render('admin/admin_Producer.html.twig', array(
            'form' => $form->createView(),
            'listProducer' => $this->producerManager->getAllProducers()
            ));
    }

    /**
     * @Route("/admin/producer/delete/{id_delete}", name="delete_producer")
     * @param int $id_delete
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @internal param $id
     */
    public function deleteProducerAction(int $id_delete, Request $request)
    {
        $submittedToken = $request->request->get('_csrf_token');

        if ($request->isMethod('POST') && $this->isCsrfTokenValid('delete-producer', $submittedToken))
        {
            $this->producerManager->deleteProducer($id_delete);
            $request->getSession()->getFlashBag()->add('info', "Le Producer a bien été supprimée.");
            return $this->redirectToRoute('create_producer');
        }
    }

    /**
     * @Route("/admin/category", name="create_category")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createCategoryAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $this->categoryManager->createCategory($request, $category);
        }

        return $this->render('admin/admin_categories.html.twig', array(
            'form' => $form->createView(),
            'listCategory' => $this->categoryManager->getAllCategories()
        ));
    }

    /**
     * @Route("/admin/category/delete/{id_delete}", name="delete_category")
     * @param int $id_delete
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @internal param $id
     */
    public function deleteCategoryAction(int $id_delete, Request $request)
    {
        $submittedToken = $request->request->get('_csrf_token');

        if ($request->isMethod('POST') && $this->isCsrfTokenValid('delete-category', $submittedToken))
        {
            $this->categoryManager->deleteCategory($id_delete);
            $request->getSession()->getFlashBag()->add('info', "Le category a bien été supprimée.");
            return $this->redirectToRoute('create_category');
        }
    }
}
