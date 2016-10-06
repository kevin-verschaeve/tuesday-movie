<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Session;
use AppBundle\Entity\User;
use AppBundle\Event\MovieEvent;
use AppBundle\Manager\SessionManager;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class MovieEventListener implements EventSubscriberInterface
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
        return [MovieEvent::MOVIE_NEW => 'onMovieNew'];
    }

    public function onMovieNew(MovieEvent $event)
    {
        $movie = $event->getMovie();
        $session = $event->getSession();

        $user = $this->doctrine->getRepository(User::class)->findOneBy(['ipAddress' => $event->getClientIp()]);

        if (!$this->sessionManager->userExistsInSession($session, $user)) {
            $user = new User();
            $user->setName($movie->getProposedBy());
            $user->setIpAddress($event->getClientIp());
        }

        $movie->addVoter($user);
        $session->addMovie($movie);

        $em = $this->doctrine->getManager();
        $em->persist($session);
        $em->flush();
    }
}
