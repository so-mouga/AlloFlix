<?php

declare(strict_types=1);

namespace AppBundle\Manager;

use AppBundle\Entity\Category;

interface IFilmCollectionByCategOrNote
{
    public function getListFilmByCategOrNote(?Category $category, ?int $note);
}
