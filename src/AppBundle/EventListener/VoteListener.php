<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Movie;
use AppBundle\Entity\User;
use AppBundle\Event\VoteEvent;
use AppBundle\Manager\SessionManager;
use AppBundle\Manager\VoteManager;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class VoteListener implements EventSubscriberInterface
{
    private $doctrine;
    private $voteManager;

    public function __construct(Registry $doctrine, VoteManager $voteManager)
    {
        $this->doctrine = $doctrine;
        $this->voteManager = $voteManager;
    }

    public static function getSubscribedEvents()
    {
        return [VoteEvent::VOTE => 'onVote'];
    }

    public function onVote(VoteEvent $event)
    {
        $vote = $event->getVote();
        $em = $this->doctrine->getManager();
        $user = $this->voteManager->findOrCreateVoter($vote->getUserName(), $event->getClientIp());

        $this->voteManager->resetVotes($event->getSession(), $user);

        /** @var Movie $movie */
        foreach ($vote->getMovies() as $movie) {
            if (!$movie instanceof Movie) {
                continue;
            }

            $movie->addVoter($user);
        }

        $em->flush();
    }
}
