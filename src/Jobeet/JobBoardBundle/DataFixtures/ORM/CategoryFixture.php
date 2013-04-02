<?php

namespace Jobeet\JobBoardBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Jobeet\JobBoardBundle\Entity\Category;

class CategoryFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $objectManager)
    {
        // Create "Design" category object
        $category = new Category();
        $category->setName('Design');

        // Persist it to the database
        $objectManager->persist($category);

        // Save a reference to this category object for use in other fixture classes
        $this->addReference('category-design', $category);

        // Create "Programming" category
        $category = new Category();
        $category->setName('Programming');
        $objectManager->persist($category);
        $this->addReference('category-programming', $category);

        // Create "Manager" category
        $category = new Category();
        $category->setName('Manager');
        $objectManager->persist($category);
        $this->addReference('category-manager', $category);

        // Create "Administrator" category
        $category = new Category();
        $category->setName('Administrator');
        $objectManager->persist($category);
        $this->addReference('category-administrator', $category);

        // Only flush() ever causes write operations against the database.
        // Other methods such as persist() only notify the UnitOfWork to perform these operations during flush.
        $objectManager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
