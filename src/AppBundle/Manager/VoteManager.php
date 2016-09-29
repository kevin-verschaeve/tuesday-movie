<?php

namespace AppBundle\Manager;

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
}
