<?php

namespace AppBundle\Twig\Extension;

use AppBundle\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Registry;

class SessionVotersExtension extends \Twig_Extension
{
    private $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getFilters()
    {
        return [new \Twig_SimpleFilter('voters', [$this, 'findSessionVoters'])];
    }

    public function findSessionVoters(Session $session)
    {
        $voters = $this->doctrine->getRepository(Session::class)->findAllVoters($session);
        dump($voters);
        die;
    }

    public function getName()
    {
        return 'session_voters';
    }
}
