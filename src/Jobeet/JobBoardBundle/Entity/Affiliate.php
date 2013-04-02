<?php

namespace Jobeet\JobBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/** @ORM\Entity */
class Affiliate
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /** @ORM\Column */
    private $url;

    /** @ORM\Column(unique=true) */
    private $email;

    /** @ORM\Column */
    private $token;

    /** @ORM\Column(type="boolean") */
    private $isActive = false;

    /** @ORM\ManyToMany(targetEntity="Category", inversedBy="affiliates") */
    private $categories;

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
