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
            ->andWhere('j.isActivated = true')
            ->orderBy('j.expiresAt', 'DESC');
    }

    public function getActiveJobs()
    {
        return $this->getActiveJobsQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    public function getActiveJobsByCategoryQueryBuilder(Category $category)
    {
        return $this->getActiveJobsQueryBuilder()
            ->andWhere('j.category = :category')
            ->setParameter('category', $category->getId());
    }

    public function getActiveJobsByCategory(Category $category, $max = null)
    {
        return $this->getActiveJobsByCategoryQueryBuilder($category)
            ->setMaxResults($max)
            ->getQuery()
            ->getResult();
    }

    public function countActiveJobsByCategory(Category $category)
    {
        return $this->getActiveJobsByCategoryQueryBuilder($category)
            ->select('COUNT(j)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function retrieveActiveJob($criteria)
    {
        return $this->getActiveJobsQueryBuilder()
            ->andWhere('j.slug = :slug')
            ->setParameter('slug', $criteria['slug'])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
