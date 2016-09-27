<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Session
 *
 * @ORM\Table(name="session")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SessionRepository")
 */
class Session
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", unique=true)
     */
    private $date;

    /**
     * @var Movie[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Movie", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="session_movies",
     *      joinColumns={@ORM\JoinColumn(name="session_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="movie_id", referencedColumnName="id")}
     * )
     */
    private $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Session
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return Movie[]|Collection
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
        $this->movies->clear();

        foreach ($movies as $movie) {
            $this->addMovie($movie);
        }
    }

    public function addMovie(Movie $movie)
    {
        if ($this->movies->contains($movie)) {
            return;
        }

        $this->movies->add($movie);
    }

    public function hasVotedForMovie(User $voter, Movie $movie)
    {
        return true;
        if ($movie->getProposedBy() === $voter->getName()) {
            return true;
        }

        return false;
    }
}

