<?php
/**
 * Created by PhpStorm.
 * User: kevinmouga
 * Date: 26/02/2018
 * Time: 16:07
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use AppBundle\Manager\CategoryManager;
use AppBundle\Manager\CommentManager;
use AppBundle\Manager\FilmManager;
use AppBundle\Manager\SagaManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FilmController extends Controller
{
    private $manager;
    /**
     * @var SagaManager
     */
    private $sagaManager;
    /**
     * @var CommentManager
     */
    private $commentManager;
    /**
     * @var CategoryManager
     */
    private $categoryManager;

    public function __construct(FilmManager $manager, SagaManager $sagaManager, CommentManager $commentManager, CategoryManager $categoryManager)
    {
        $this->manager = $manager;
        $this->sagaManager = $sagaManager;
        $this->commentManager = $commentManager;
        $this->categoryManager = $categoryManager;
    }

    /**
     * @Route("/films/{idPage}", name="films", requirements={"idPage" = "\d+"})
     *
     * @param $idPage
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filmsAction(int $idPage)
    {
        $nbPerPage = 3;
        $categories = $this->categoryManager->getAllCategories();
        $notes = $this->commentManager::NOTES;

        $data = $this->manager->getAllFilms($idPage, $nbPerPage);
        return $this->render('film/list_films.html.twig', [
            'listFilms'  => $data[0],
            'nbPages'    => $data[1],
            'page'       => $idPage,
            'categories' => $categories,
            'notes'      => $notes
        ]);
    }

    /**
     * @Route("/film/{filmID}", name="film", requirements={"filmID" = "\d+"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filmAction(Request $request, $filmID)
    {
        $film = $this->manager->getFilmById($filmID);

        if (null === $film) {
            throw new NotFoundHttpException("La page n'existe pas");
        }

        $comment = new Comment();
        $comment->setUser($this->getUser());
        $comment->setFilm($film);

        $commentUser = $this->commentManager->getCommentByUser($film, $this->getUser());

        if ($commentUser){
            $comment = $commentUser;
        }

        $form = $this->createForm(CommentType::class,$comment);

        if ($request->isMethod('POST') AND  $form->handleRequest($request)->isValid()){

            $this->commentManager->addComment($comment);
        }

            return $this->render('film/film.html.twig',[
                'myFilm'    =>  $film,
                'form'      =>  $form->createView(),
                'myComment' =>  $commentUser
        ]);
    }

    /**
     * @Route("/playlist_heart", name="film_heart")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filmHeartStrokeAction()
    {
        return $this->render('film/film_heart_stroke.html.twig');
    }

    /**
     * @Route("/playlist_later", name="film_later")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filmWatchLaterAction()
    {
        return $this->render('film/film_watch_later.html.twig');
    }
}
