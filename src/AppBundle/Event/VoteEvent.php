<?php

namespace AppBundle\Event;

use AppBundle\Entity\Session;
use AppBundle\Model\Vote;
use Symfony\Component\EventDispatcher\Event;

class VoteEvent extends Event
{
    const VOTE = 'vote';

    private $session;
    private $vote;
    private $clientIp;

    public function __construct(Session $session, Vote $vote, string $clientIp)
    {
        $this->session = $session;
        $this->vote = $vote;
        $this->clientIp = $clientIp;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return Vote
     */
    public function getVote(): Vote
    {
        return $this->vote;
    }

    /**
     * @return string
     */
    public function getClientIp()
    {
        return $this->clientIp;
    }
}
