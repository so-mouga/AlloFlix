<?php
/**
 * Created by PhpStorm.
 * User: kevinmouga
 * Date: 26/02/2018
 * Time: 16:07
 */

namespace AppBundle\Controller;

use AppBundle\Manager\FilmManager;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FilmController extends Controller
{
    private $manager;
    private $logger;

    public function __construct(FilmManager $manager, LoggerInterface $logger)
    {
        $this->manager = $manager;
        $this->logger = $logger;
    }

    /**
     * @Route("/films/{idPage}", name="films")
     *
     * @param $idPage
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filmsAction(int $idPage)
    {
        $nbPerPage = 3;
        $data = $this->manager->getAllFilms($idPage, $nbPerPage);
        return $this->render('film/list_films.html.twig', [
            'listFilms' => $data[0],
            'nbPages' => $data[1],
            'page' => $idPage,
        ]);
    }

    /**
     * @Route("/film/{filmID}", name="film", requirements={"filmID" = "\d+"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filmAction($filmID)
    {
        return $this->render('film/film.html.twig');
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
    /**
     * SearchFilmAction
     *
     * @Route("/film/search", name="film_search", condition="request.isXmlHttpRequest()")
     */
    public function searchFilmAction(Request $request){
        $word = $request->query->get('search');
        $films = $this->manager->getFilmSearch($word);
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
}
