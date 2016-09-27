<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Movie;
use AppBundle\Entity\User;
use AppBundle\Event\VoteEvent;
use AppBundle\Manager\SessionManager;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class VoteListener implements EventSubscriberInterface
{
    private $doctrine;
    private $sessionManager;

    public function __construct(Registry $doctrine, SessionManager $sessionManager)
    {
        $this->doctrine = $doctrine;
        $this->sessionManager = $sessionManager;
    }

    public static function getSubscribedEvents()
    {
        return [VoteEvent::VOTE => 'onVote'];
    }

    public function onVote(VoteEvent $event)
    {
        $vote = $event->getVote();

        $user = $this->sessionManager->getVoterForSession($vote->getUserName(), $event->getClientIp());

        /** @var Movie $movie */
        foreach ($vote->getMovies() as $movie) {
            $movie->addVoter($user);
        }

        $em = $this->doctrine->getManager();
        $em->persist($movie);
        $em->flush();
    }
}
