<?php

namespace Jobeet\JobBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="Jobeet\JobBoardBundle\Entity\JobRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Job
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(unique=true)
     * @Gedmo\Slug(fields={"company", "location", "position"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="jobs")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $category;

    /**
     * @ORM\Column(nullable=true)
     * @Assert\Choice(choices={"full-time", "part-time", "freelance"})
     */
    private $type;

    /** @ORM\Column */
    private $company;

    /** @ORM\Column(nullable=true) */
    private $logoPath;

    /** @Assert\Image */
    private $logoFile;

    /** @var string The absolute directory path where uploaded logos should be saved */
    private $uploadDir;

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

    /**
     * @ORM\Column
     * @Assert\Email
     */
    private $email;

    /** @ORM\Column(type="datetime") */
    private $expiresAt;

    /** @var integer Number of days a job is active */
    private $activeDays;

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

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Job
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Job
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set company
     *
     * @param string $company
     * @return Job
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set logoPath
     *
     * @param string $logoPath
     * @return Job
     */
    public function setLogoPath($logoPath)
    {
        $this->logoPath = $logoPath;

        return $this;
    }

    /**
     * Get logoPath
     *
     * @return string
     */
    public function getLogoPath()
    {
        return $this->logoPath;
    }

    /**
     * Set uploaded logo file
     *
     * @param UploadedFile $logoFile
     * @return Job
     */
    public function setLogoFile(UploadedFile $logoFile)
    {
        $this->logoFile = $logoFile;

        return $this;
    }

    /**
     * Get uploaded logo file
     *
     * @return UploadedFile
     */
    public function getLogoFile()
    {
        return $this->logoFile;
    }

    /**
     * Set logo path from an uploaded logo file
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setLogoPathFromFile()
    {
        if ($file = $this->getLogoFile()) {
            $uniqueFilename = uniqid(mt_rand(), true);
            $this->setLogoPath($uniqueFilename.'.'.$file->guessExtension());
        }
    }

    /**
     * Move uploaded logo file to a permanent location
     *
     * @ORM\PostPersist
     * @ORM\PostUpdate
     */
    public function moveLogoFile()
    {
        if ($file = $this->getLogoFile()) {
            $file->move($this->uploadDir, $this->getLogoPath());
        }
    }

    /**
     * Set uploadDir
     *
     * @param string $uploadDir
     * @return Job
     */
    public function setUploadDir($uploadDir)
    {
        $this->uploadDir = $uploadDir;

        return $this;
    }

    /**
     * Get uploadDir
     *
     * @return string
     */
    public function getUploadDir()
    {
        return $this->uploadDir;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Job
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return Job
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Job
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Job
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set howToApply
     *
     * @param string $howToApply
     * @return Job
     */
    public function setHowToApply($howToApply)
    {
        $this->howToApply = $howToApply;

        return $this;
    }

    /**
     * Get howToApply
     *
     * @return string
     */
    public function getHowToApply()
    {
        return $this->howToApply;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Job
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set token default value
     *
     * @ORM\PrePersist
     */
    public function setDefaultToken()
    {
        if (!$this->getToken()) {
            $this->setToken(sha1($this->getEmail().rand(11111, 99999)));
        }
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     * @return Job
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * Get isPublic
     *
     * @return boolean
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * Set isActivated
     *
     * @param boolean $isActivated
     * @return Job
     */
    public function setIsActivated($isActivated)
    {
        $this->isActivated = $isActivated;

        return $this;
    }

    /**
     * Get isActivated
     *
     * @return boolean
     */
    public function getIsActivated()
    {
        return $this->isActivated;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Job
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set expiresAt
     *
     * @param \DateTime $expiresAt
     * @return Job
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * Get expiresAt
     *
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Set expiresAt default value
     *
     * @ORM\PrePersist
     */
    public function setDefaultExpiresAt()
    {
        if (!$this->getExpiresAt()) {
            $now = $this->getCreatedAt() ? clone $this->getCreatedAt() : new \DateTime();
            $this->setExpiresAt($now->modify("+{$this->activeDays} days"));
        }
    }

    public function isExpired()
    {
        return $this->getDaysBeforeExpires() < 0;
    }

    public function expiresSoon()
    {
        return $this->getDaysBeforeExpires() < 5;
    }

    public function getDaysBeforeExpires()
    {
        return (new \DateTime())->diff($this->getExpiresAt())->format('%r%d');
    }

    public function extend()
    {
        if ($this->expiresSoon()) {
            $this->setExpiresAt(new \DateTime("+{$this->activeDays} days"));

            return true;
        } else {
            return false;
        }
    }

    /**
     * Set activeDays
     *
     * @param integer $activeDays
     * @return Job
     */
    public function setActiveDays($activeDays)
    {
        $this->activeDays = $activeDays;

        return $this;
    }

    /**
     * Get activeDays
     *
     * @return integer
     */
    public function getActiveDays()
    {
        return $this->activeDays;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Job
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Job
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set category
     *
     * @param \Jobeet\JobBoardBundle\Entity\Category $category
     * @return Job
     */
    public function setCategory(\Jobeet\JobBoardBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Jobeet\JobBoardBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
