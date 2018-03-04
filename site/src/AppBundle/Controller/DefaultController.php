<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Manager\FilmManager;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(FilmManager $filmManager)
    {
        $listFilmSelection = $filmManager->getFilmSelected();
        $listFilmCurrent = $filmManager->getFilmByCreatedAt();
        
        
        return $this->render('default/index.html.twig' , array(
            "listFilmSelected" => $listFilmSelection ,
            "listFilmCurrent" => $listFilmCurrent
        ));
    }
}
