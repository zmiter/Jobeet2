<?php

namespace Jobeet\JobBoardBundle\Entity;

use Doctrine\ORM\EntityRepository;

class JobRepository extends EntityRepository
{
    public function getActiveJobs()
    {
        return $this->createQueryBuilder('j')
            ->where('j.expiresAt > :now')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();
    }
}
