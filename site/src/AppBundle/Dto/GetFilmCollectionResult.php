<?php

declare(strict_types=1);

namespace AppBundle\Dto;

use ArrayAccess;
use Exception;
use Iterator;

class GetFilmCollectionResult implements ArrayAccess
{
    private $filmsCollectionIterator;
    private $nbPages;

    public function __construct(Iterator $filmsCollectionIterator, int $nbPages)
    {
        $this->filmsCollectionIterator = $filmsCollectionIterator;
        $this->nbPages = $nbPages;
    }

    public function offsetExists($offset)
    {
        return $offset === 0 || $offset === 1;
    }

    /**
     * @param mixed $offset
     * @return Iterator|int
     * @throws Exception
     */
    public function offsetGet($offset)
    {
        if ($offset === 0) {
            return $this->filmsCollectionIterator;
        }

        if ($offset === 1) {
            return $this->nbPages;
        }

        throw new Exception('cannot get the value');
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws Exception
     */
    public function offsetSet($offset, $value)
    {
        throw new Exception('cannot set the value');
    }

    /**
     * @param mixed $offset
     * @throws Exception
     */
    public function offsetUnset($offset)
    {
        throw new Exception('cannot unset the value');
    }

    public function getFilmsCollection() : Iterator
    {
        return $this->filmsCollectionIterator;
    }

    public function getNbPages() : int
    {
        return $this->nbPages;
    }
}
