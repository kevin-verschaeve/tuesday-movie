<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Session;
use AppBundle\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Collections\ArrayCollection;

class SessionManager
{
    const NEXT_MONTHS = [
        'January' => 'February',
        'February' => 'March',
        'March' => 'April',
        'April' => 'May',
        'May' => 'June',
        'June' => 'July',
        'July' => 'August',
        'August' => 'September',
        'September' => 'October',
        'October' => 'November',
        'November' => 'December',
        'December' => 'January',
    ];

    private $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function findFirstTuesdayOfMonth($month, $isNext = false)
    {
        $currentDate = new \DateTime();
        $year = $currentDate->format('Y');
        $month = $isNext ? self::NEXT_MONTHS[$month] : $month;

        if ('January' === $month && $isNext) {
            ++$year;
        }

        $movieDay = new \DateTime(sprintf(
            "First Tuesday of %s %s",
            $month,
            $year
        ));

        return $movieDay;
    }

    public function sessionExists($nextMovieDay)
    {
        return (bool) $this
            ->doctrine
            ->getRepository(Session::class)
            ->findOneBy(['date' => $nextMovieDay]);
    }

    /**
     * @return Session
     */
    public function findCurrentSession()
    {
        $currentDate = new \DateTime();
        $currentMonth = $currentDate->format('F');

        $repository = $this->doctrine->getRepository(Session::class);

        $firstTuesdayOfCurrentMonth = $this->findFirstTuesdayOfMonth($currentMonth);
        if ($currentDate > $firstTuesdayOfCurrentMonth) {
            return $repository->findOneByDate($this->findFirstTuesdayOfMonth($currentMonth, true));
        }

        return $repository->findOneByDate($firstTuesdayOfCurrentMonth);
    }

    public function findCurrentMonth()
    {
        return (new \DateTime())->format('F');
    }

    public function findAllVoters(Session $session)
    {
        $voters = new ArrayCollection();
        foreach ($session->getMovies() as $movie) {
            foreach ($movie->getVoters() as $voter) {
                if ($voters->contains($voter)) {
                    continue;
                }

                $voters[] = $voter;
            }
        }

        return $voters;
    }

    public function userExistsInSession(Session $session, User $user= null)
    {
        if (null === $user) {
            return false;
        }

        $voters = $this->findAllVoters($session);

        return $voters->contains($user);
    }
}
