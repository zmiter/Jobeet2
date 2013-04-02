<?php

namespace Jobeet\JobBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/** @ORM\Entity */
class Category
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /** @ORM\Column(unique=true) */
    private $name;

    /** @ORM\OneToMany(targetEntity="Job", mappedBy="category") */
    private $jobs;

    /** @ORM\ManyToMany(targetEntity="Affiliate", mappedBy="categories") */
    private $affiliates;

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
