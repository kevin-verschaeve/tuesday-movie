<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Session;
use AppBundle\Entity\User;
use AppBundle\Event\MovieEvent;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class MovieEventListener implements EventSubscriberInterface
{
    private $doctrine;
    private $flashBag;

    public function __construct(Registry $doctrine, FlashBag $flashBag)
    {
        $this->doctrine = $doctrine;
        $this->flashBag = $flashBag;
    }
    public static function getSubscribedEvents()
    {
        return [MovieEvent::MOVIE_NEW => 'onMovieNew'];
    }

    public function onMovieNew(MovieEvent $event)
    {
        $movie = $event->getMovie();
        $session = $event->getSession();

        $user = new User();
        $user->setName($movie->getProposedBy());
        $user->setIpAddress($event->getClientIp());

        $movie->addVoter($user);
        $session->addMovie($movie);

        $em = $this->doctrine->getManager();
        $em->persist($session);
        $em->flush();

        $this->flashBag->add('success', 'Film ajouté a la liste');
    }
}
