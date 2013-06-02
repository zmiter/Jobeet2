<?php

namespace Jobeet\JobBoardBundle\Factory;

use Jobeet\JobBoardBundle\Entity\Job;
use Doctrine\ORM\Event\LifecycleEventArgs;

class JobFactory
{
    private $activeDays;
    private $uploadDir;

    public function __construct($activeDays, $uploadDir)
    {
        $this->activeDays = $activeDays;
        $this->uploadDir = $uploadDir;
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
        $job->setUploadDir($this->uploadDir);
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Job) {
            $this->configure($entity);
        }
    }
}
