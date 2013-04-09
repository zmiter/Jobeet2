<?php

namespace Jobeet\JobBoardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jobeet\JobBoardBundle\Entity\Category;

/**
 * Category controller.
 *
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{slug}", name="category_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Category $category)
    {
        return array(
            'entity' => $category,
        );
    }
}
