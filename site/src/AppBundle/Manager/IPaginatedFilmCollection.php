<?php

declare(strict_types=1);

namespace AppBundle\Manager;

interface IPaginatedFilmCollection
{
    public function getAllFilms(int $page,int $nbPerPage);
}
