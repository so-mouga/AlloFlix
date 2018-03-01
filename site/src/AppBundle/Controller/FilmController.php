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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class FilmController extends Controller
{
    /**
     * @var FilmManager
     */
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
        $nbPerPage = 6;
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

        $notes = $this->manager->getRateByFilm($film);
        $filmHeart = $this->manager->getFilmHeartByUser($this->getUser(), $film);
        $filmWatchLater = $this->manager->getFilmWatchLaterByUser($this->getUser(), $film);

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
                'myFilm'         =>  $film,
                'form'           =>  $form->createView(),
                'myComment'      =>  $commentUser,
                'noteMovie'      =>  $notes,
                'filmHeart'      =>  $filmHeart,
                'filmWatchLater' =>  $filmWatchLater,
        ]);
    }

    /**
     * @Route("/film/playlist_heart", name="film_heart")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filmHeartStrokeAction()
    {
        return $this->render('film/film_heart_stroke.html.twig',[
            'filmsHeart' =>  $this->getUser()->getListFilmHeartStroke()->getValues()
        ]);
    }

    /**
     * @Route("/film/playlist_later", name="film_later")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filmWatchLaterAction()
    {
        return $this->render('film/film_watch_later.html.twig', [
            'filmsWait' =>  $this->getUser()->getListFilmWatchLater()->getValues()
        ]);
    }

    /**
     * SearchFilmAction
     *
     * @Route("/search_ajax", name="film_search", condition="request.isXmlHttpRequest()")
     */
    public function searchFilmAction(Request $request){
        $word = $request->query->get('search');
        $films = $this->manager->searchFilm($word);
        $items = array();
        $response = new JsonResponse();
        foreach ($films as $film){
            $items[] = [
                'id' => $film->getId(),
                'name' => $film->getName()
            ];

        }
         return $response->setData(array('films'=>$items));
    }

    /**
     * @Route("/love_film_js", name="love_film_js")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loveFilmAction(Request $request)
    {
        $loveUserFilm = $request->request->get('love');
        $filmId = $request->request->get('filmId');
        $film = $this->manager->getFilmById($filmId);

        if (empty($film)) {
            return new JsonResponse(['message' => 'film no found'], Response::HTTP_NOT_FOUND);
        }

        if ($loveUserFilm == 'true'){
            $this->manager->addFilmHeart($film, $this->getUser());
            $love = true;
        }

        if ($loveUserFilm == 'false'){
            $this->manager->removeFilmHeart($film, $this->getUser());
            $love = false;
        }
        return new JsonResponse(['data' =>  $filmId, 'love' => $love]);
    }

    /**
     * @Route("/watch_film_js", name="watch_film_js")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function watchFilmAction(Request $request)
    {
        $watchUserFilm = $request->request->get('later');
        $filmId = $request->request->get('filmId');
        $film = $this->manager->getFilmById($filmId);

        if (empty($film)) {
            return new JsonResponse(['message' => 'film no found'], Response::HTTP_NOT_FOUND);
        }

        if ($watchUserFilm == 'true'){
            $this->manager->addFilmWatch($film, $this->getUser());
            $watch = true;
        }

        if ($watchUserFilm == 'false'){
            $this->manager->removeFilmWatch($film, $this->getUser());
            $watch = false;
        }
        return new JsonResponse(['data' =>  $filmId, 'watch' => $watch]);
    }

    /**
     * @Route("/search_film_top", name="search_film_top")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filmTopBarreAction(Request $request)
    {
        $nameFilm = $request->request->get('film_name');
        $film = $this->manager->getFilmByName($nameFilm);

        if (!empty($film)) {
            return $this->redirectToRoute('film',[
                'filmID' => $film[0]->getId()
            ]);
        }
        return $this->redirectToRoute('film_no_found',[
            'filmName' =>  $nameFilm
        ]);
    }

    /**
     * @Route("/film/no_found/{filmName}", name="film_no_found")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filmNoFoundAction($filmName)
    {
        return $this->render('film/film_no_found.html.twig', [
            'filmName' => $filmName
        ]);
    }
}

