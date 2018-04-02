<?php

declare(strict_types=1);

namespace AppBundle\Repository;

use AppBundle\Entity\Film;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class FilmRepository extends EntityRepository
{
    public function getAllFilm(int $page, int $nbPerPage) : Paginator
    {
        $query = $this->createQueryBuilder('f')->getQuery();

        $query
            ->setFirstResult(($page - 1) * $nbPerPage)
            ->setMaxResults($nbPerPage);

        return new Paginator($query, true);
    }

    public function searchFilm(string $search)
    {

        $query = $this->createQueryBuilder('search')
            ->select('f')
            ->from(Film::class, 'f')
            ->where('f.name LIKE :word')
            ->setParameter('word','%'.$search.'%')
            ->getQuery()
            ->getResult()
        ;
        return $query;
    }
}
