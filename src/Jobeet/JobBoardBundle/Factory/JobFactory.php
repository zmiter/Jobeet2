<?php

namespace Jobeet\JobBoardBundle\Factory;

use Jobeet\JobBoardBundle\Entity\Job;

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
        $job->setActiveDays($this->activeDays);

        return $job;
    }
}
