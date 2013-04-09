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
    public function showAction(Request $request, Category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $pagination = $this->get('knp_paginator')->paginate(
            $em->getRepository('JobeetJobBoardBundle:Job')->getActiveJobsByCategoryQueryBuilder($category),
            $request->query->get('page', 1),
            $this->container->getParameter('jobeet_job_board.max_jobs_on_category')
        );

        return array(
            'category' => $category,
            'pagination' => $pagination
        );
    }
}
