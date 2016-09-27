<?php

namespace AppBundle\Event;

use AppBundle\Entity\Movie;
use AppBundle\Entity\Session;
use Symfony\Component\EventDispatcher\Event;

class MovieEvent extends Event
{
    const MOVIE_NEW = 'movie.new';

    private $movie;
    private $session;
    private $clientIp;

    public function __construct(Movie $movie, Session $session, string $clientIp)
    {
        $this->movie = $movie;
        $this->session = $session;
        $this->clientIp = $clientIp;
    }

    /**
     * @return Movie
     */
    public function getMovie(): Movie
    {
        return $this->movie;
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }

    /**
     * @return string
     */
    public function getClientIp(): string
    {
        return $this->clientIp;
    }
}
