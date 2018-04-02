<?php

declare(strict_types=1);

namespace AppBundle\Action\Film;

use AppBundle\Manager\CategoryManager;
use AppBundle\Manager\CommentManager;
use AppBundle\Manager\IPaginatedFilmCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

final class PaginatedListAction
{
    private const TEMPLATE = 'film/list_films.html.twig';

    private $renderer;

    private $filmManager;

    private $commentManager;

    private $categoryManager;

    public function __construct(
        Twig_Environment $renderer,
        IPaginatedFilmCollection $filmManager,
        CommentManager $commentManager,
        CategoryManager $categoryManager
    ) {
        $this->renderer = $renderer;
        $this->filmManager = $filmManager;
        $this->commentManager = $commentManager;
        $this->categoryManager = $categoryManager;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(Request $request) : Response
    {
        $idPage = (int) $request->get('idPage', 0);
        $nbPerPage = 6;

        $categories = $this->categoryManager->getAllCategories();
        $notes = $this->commentManager::NOTES;
        $data = $this->filmManager->getAllFilms($idPage, $nbPerPage);

        return new Response($this->renderer->render(self::TEMPLATE, [
            'listFilms' => $data[0],
            'nbPages' => $data[1],
            'page' => $idPage,
            'categories' => $categories,
            'notes' => $notes
        ]));
    }
}
