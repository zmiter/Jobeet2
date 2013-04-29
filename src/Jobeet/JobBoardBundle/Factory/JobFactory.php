<?php

namespace Jobeet\JobBoardBundle\Factory;

use Jobeet\JobBoardBundle\Entity\Job;
use Doctrine\ORM\Event\LifecycleEventArgs;

class JobFactory
{
    private $activeDays;

    public function __construct($activeDays)
    {
        $this->activeDays = $activeDays;
    }

    public function get()
    {
        $job = new Job();
        $this->configure($job);

        return $job;
    }

    public function configure(Job $job)
    {
        $job->setActiveDays($this->activeDays);
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Job) {
            $this->configure($entity);
        }
    }
}
