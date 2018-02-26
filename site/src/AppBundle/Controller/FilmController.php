<?php
/**
 * Created by PhpStorm.
 * User: kevinmouga
 * Date: 26/02/2018
 * Time: 16:07
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FilmController extends Controller
{
    /**
     * @Route("/films", name="films")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filmsAction()
    {
        return $this->render('film/list_films.html.twig');
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
}