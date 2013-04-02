<?php

namespace Jobeet\JobBoardBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Jobeet\JobBoardBundle\Entity\Job;

class JobFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $objectManager)
    {
        // Create full-time programming job object
        $job = new Job();
        $job->setCategory($this->getReference('category-programming'));
        $job->setType('full-time');
        $job->setCompany('Sensio Labs');
        $job->setLogoPath('sensio-labs.gif');
        $job->setUrl('http://www.sensiolabs.com/');
        $job->setPosition('Web Developer');
        $job->setLocation('Paris, France');
        $job->setDescription("You've already developed websites with symfony and you want to work with Open-Source technologies. You have a minimum of 3 years experience in web development with PHP or Java and you wish to participate to development of Web 2.0 sites using the best frameworks available.");
        $job->setHowToApply('Send your resume to fabien.potencier [at] sensio.com');
        $job->setIsPublic(true);
        $job->setIsActivated(true);
        $job->setToken('job_sensio_labs');
        $job->setEmail('job@example.com');
        $job->setExpiresAt(new \DateTime('2016-04-10'));

        // Persist it to the database
        $objectManager->persist($job);

        // Save a reference to this job object for use in other fixture classes
        $this->addReference('job-sensio-labs', $job);

        // Create part-time design job
        $job = new Job();
        $job->setCategory($this->getReference('category-design'));
        $job->setType('part-time');
        $job->setCompany('Extreme Sensio');
        $job->setLogoPath('extreme-sensio.gif');
        $job->setUrl('http://www.extreme-sensio.com/');
        $job->setPosition('Web Designer');
        $job->setLocation('Paris, France');
        $job->setDescription(
<<<EOT
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.

Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
EOT
        );
        $job->setHowToApply('Send your resume to fabien.potencier [at] sensio.com');
        $job->setIsPublic(true);
        $job->setIsActivated(true);
        $job->setToken('job_extreme_sensio');
        $job->setEmail('job@example.com');
        $job->setExpiresAt(new \DateTime('2016-04-10'));
        $objectManager->persist($job);
        $this->addReference('job-extreme-sensio', $job);

        // Only flush() ever causes write operations against the database.
        // Other methods such as persist() only notify the UnitOfWork to perform these operations during flush.
        $objectManager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
