<?php

namespace Jobeet\JobBoardBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function getWithJobs()
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.jobs', 'j')
            ->where('j.expiresAt > :now')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();
    }
}
