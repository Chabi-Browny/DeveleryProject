<?php

namespace App\Service;

use App\Helper\PaginationHelper;
use Twig\Environment;
/**
 * Description of PaginationService
 */
class PaginationService
{
    const DEFAULT_LIMIT = 2;
    const FIRST_PAGE_NUMBER = 1;

    protected $pagiHelpr;

    /**
     * @desc - This is the Offset to
     * @var int
     */
    protected $currentPage;

    /**
     * @desc - The total row of the table
     * @var int
     */
    protected $total;

    /**
     * @desc - The number of per page
     * @var int
     */
    protected $limit;

    public function __construct( private Environment $twig ){}

    /**/
    public function initPagination(int $current, int $total, int $limit = self::DEFAULT_LIMIT)
    {
        $this->currentPage = $current;
        $this->total = $total;
        $this->limit = $limit;
    }

    /**/
    public function getFirst()
    {
        return self::FIRST_PAGE_NUMBER;
    }

    /**/
    public function getLast()
    {
        return (int) ceil($this->total / $this->limit );
    }

    /**/
    public function getNext()
    {
        return $this->currentPage + 1;
    }

    /**/
    public function getPrevious()
    {
        return $this->currentPage - 1;
    }

    /**/
    public function getLimit()
    {
        return $this->limit;
    }

    /**/
    public function getOffset($limit)
    {
        $offset = 0;

        if ($this->currentPage > self::FIRST_PAGE_NUMBER)
        {
            $offset = $this->getPrevious() * $this->getLimit();
        }

        return $offset;
    }

    /**/
    public function getPageLinks()
    {
        $links = [];
        for ($c = $this->getFirst(); $c <= $this->getLast(); $c++)
        {
            $label = $c;
            $links [$label] = [
                'active'  => $this->currentPage === $c,
                'linkNum' => $c
            ];
        }

        return $links;
    }

    /**/
    public function hasNext()
    {
        return !($this->getNext() >  $this->getLast());
    }

    /**/
    public function hasPrevious()
    {
        return !($this->getPrevious() < $this->getFirst());
    }

    /**/
    public function renderPagi(array $queryResult)
    {
        return $this->twig->render('pageParts/pagination.html.twig', [
            'hasNext'     => $this->hasNext(),
            'hasPrevious' => $this->hasPrevious(),
            'next'        => $this->getNext(),
            'previous'    => $this->getPrevious(),
            'first'       => $this->getFirst(),
            'last'        => $this->getLast(),
            'links'       => $this->getPageLinks()
        ]);
    }
}
