<?php

namespace AppBundle\Model;

use AppBundle\Entity\Movie;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Vote
{
    /**
     * @var string
     */
    private $userName;

    /**
     * @var array
     */
    private $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName = null)
    {
        $this->userName = $userName;
    }

    /**
     * @return array
     */
    public function getMovies()
    {
        return $this->movies;
    }

    /**
     * @param Movie[]|Collection $movies
     */
    public function setMovies(Collection $movies)
    {
        $this->movies = $movies;
    }
}
