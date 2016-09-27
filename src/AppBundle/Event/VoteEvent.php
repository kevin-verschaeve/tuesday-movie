<?php

namespace AppBundle\Event;

use AppBundle\Model\Vote;
use Symfony\Component\EventDispatcher\Event;

class VoteEvent extends Event
{
    const VOTE = 'vote';

    private $vote;
    private $clientIp;

    public function __construct(Vote $vote, string $clientIp)
    {
        $this->vote = $vote;
        $this->clientIp = $clientIp;
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
