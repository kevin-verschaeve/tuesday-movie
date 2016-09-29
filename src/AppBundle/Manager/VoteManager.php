<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Session;
use AppBundle\Entity\User;
use AppBundle\Model\Vote;
use Doctrine\Bundle\DoctrineBundle\Registry;

class VoteManager
{
    private $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function prepareVote(string $ipAddress)
    {
        $user = $this->doctrine->getRepository(User::class)->findOneBy(['ipAddress' => $ipAddress]);

        $vote = new Vote();
        $vote->setUserName($user ? $user->getName() : null);

        return $vote;
    }

    public function resetVotes(Session $session, User $voter)
    {
        foreach ($session->getMovies() as $movie) {
            $movie->removeVoter($voter);
        }
    }

    public function findOrCreateVoter(string $userName, string $ipAddress)
    {
        $user = $this->doctrine->getRepository(User::class)->findOneBy([
            'ipAddress' => $ipAddress,
        ]);

        if ($user) {
            return $user;
        }

        $user = new User();
        $user->setName($userName);
        $user->setIpAddress($ipAddress);

        return $user;
    }
}
