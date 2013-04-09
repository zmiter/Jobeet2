<?php

namespace Jobeet\JobBoardBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Jobeet\JobBoardBundle\Entity\Category;

class JobRepository extends EntityRepository
{
    private function getActiveJobsQueryBuilder()
    {
        return $this->createQueryBuilder('j')
            ->where('j.expiresAt > :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('j.expiresAt', 'DESC');
    }

    public function getActiveJobs()
    {
        return $this->getActiveJobsQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    public function getActiveJobsByCategory(Category $category, $max = 10)
    {
        return $this->getActiveJobsQueryBuilder()
            ->andWhere('j.category = :category')
            ->setParameter('category', $category)
            ->setMaxResults($max)
            ->getQuery()
            ->getResult();
    }
}
