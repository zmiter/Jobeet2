<?php

namespace Jobeet\JobBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/** @ORM\Entity */
class Job
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="jobs")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $category;

    /** @ORM\Column(nullable=true) */
    private $type;

    /** @ORM\Column */
    private $company;

    /** @ORM\Column(nullable=true) */
    private $logoPath;

    /** @ORM\Column(nullable=true) */
    private $url;

    /** @ORM\Column */
    private $position;

    /** @ORM\Column */
    private $location;

    /** @ORM\Column(type="text") */
    private $description;

    /** @ORM\Column(type="text") */
    private $howToApply;

    /** @ORM\Column(unique=true) */
    private $token;

    /** @ORM\Column(type="boolean") */
    private $isPublic = true;

    /** @ORM\Column(type="boolean") */
    private $isActivated = false;

    /** @ORM\Column */
    private $email;

    /** @ORM\Column(type="datetime") */
    private $expiresAt;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;
}
