<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Session;
use Doctrine\ORM\EntityRepository;

class SessionRepository extends EntityRepository
{
    public function findAllVoters(Session $session)
    {
        return $this->createQueryBuilder('s')
            ->select('u')
            ->join('s.movies', 'm')
            ->join('m.voters', 'u')
            ->where('s = :session')
            ->setParameter('session', $session)
            ->getQuery()
            ->getResult()
        ;
    }
}
