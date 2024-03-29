<?php

namespace Jobeet\JobBoardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Jobeet\JobBoardBundle\Entity\Job;
use Jobeet\JobBoardBundle\Entity\Category;
use Jobeet\JobBoardBundle\Form\JobType;

/**
 * Job controller.
 *
 * @Route("/job")
 */
class JobController extends Controller
{
    /**
     * Lists all Job entities.
     *
     * @Route("/", name="job")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('JobeetJobBoardBundle:Category')->getWithJobs();

        return array(
            'categories' => $categories,
        );
    }

    /**
     * Lists all Job entities by category.
     *
     * @Template()
     */
    public function listByCategoryAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $maxJobsOnHomepage = $this->container->getParameter('jobeet_job_board.max_jobs_on_homepage');

        $repository = $em->getRepository('JobeetJobBoardBundle:Job');
        $jobs = $repository->getActiveJobsByCategory($category, $maxJobsOnHomepage);
        $count = $repository->countActiveJobsByCategory($category);

        return array(
            'category' => $category,
            'jobs'     => $jobs,
            'count'    => $count
        );
    }

    /**
     * Creates a new Job entity.
     *
     * @Route("/", name="job_create")
     * @Method("POST")
     * @Template("JobeetJobBoardBundle:Job:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = $this->get('jobeet_job_board.job_factory')->get();
        $form = $this->createForm(new JobType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('job_preview', array('token' => $entity->getToken())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Job entity.
     *
     * @Route("/new", name="job_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = $this->get('jobeet_job_board.job_factory')->get();
        $form   = $this->createForm(new JobType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Job entity.
     *
     * @Route("/{slug}", name="job_show")
     * @Method("GET")
     * @Template()
     * @ParamConverter(class="JobeetJobBoardBundle:Job", options={"repository_method" = "retrieveActiveJob"})
     */
    public function showAction(Job $job)
    {
        return array(
            'job' => $job
        );
    }

    /**
     * Finds and displays a Job entity with admin bar.
     *
     * @Route("/{token}/preview", name="job_preview")
     * @Method("GET")
     * @Template()
     */
    public function previewAction(Job $job)
    {
        $deleteForm = $this->createDeleteForm($job);
        $publishForm = $this->createPublishForm($job);
        $extendForm = $this->createExtendForm($job);

        return array(
            'job' => $job,
            'delete_form' => $deleteForm->createView(),
            'publish_form' => $publishForm->createView(),
            'extend_form' => $extendForm->createView()
        );
    }

    /**
     * Publishes an existing Job entity.
     *
     * @Route("/{token}/publish", name="job_publish")
     * @Method("PUT")
     */
    public function publishAction(Request $request, Job $job)
    {
        $form = $this->createPublishForm($job);
        $form->bind($request);

        if ($form->isValid()) {
            $job->setIsActivated(true);

            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->redirect($this->generateUrl('job_show', array('slug' => $job->getSlug())));
    }

    /**
     * Extends an existing Job entity.
     *
     * @Route("/{token}/extend", name="job_extend")
     * @Method("PUT")
     */
    public function extendAction(Request $request, Job $job)
    {
        $form = $this->createExtendForm($job);
        $form->bind($request);

        if ($form->isValid()) {
            if ($job->extend()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
            } else {
                throw $this->createNotFoundException('You can extend the job only when it is expiring in less than five days.');
            }
        }

        return $this->redirect($this->generateUrl('job_show', array('slug' => $job->getSlug())));
    }

    /**
     * Displays a form to edit an existing Job entity.
     *
     * @Route("/{token}/edit", name="job_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Job $job)
    {
        if ($job->getIsActivated()) {
            throw $this->createNotFoundException('When a job is published, you cannot edit it anymore.');
        }

        $editForm = $this->createForm(new JobType(), $job);
        $deleteForm = $this->createDeleteForm($job);

        return array(
            'entity'      => $job,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Job entity.
     *
     * @Route("/{token}", name="job_update")
     * @Method("PUT")
     * @Template("JobeetJobBoardBundle:Job:edit.html.twig")
     */
    public function updateAction(Request $request, Job $job)
    {
        if ($job->getIsActivated()) {
            throw $this->createNotFoundException('When a job is published, you cannot edit it anymore.');
        }

        $deleteForm = $this->createDeleteForm($job);
        $editForm = $this->createForm(new JobType(), $job);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            return $this->redirect($this->generateUrl('job_edit', array('token' => $job->getToken())));
        }

        return array(
            'entity'      => $job,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Job entity.
     *
     * @Route("/{token}", name="job_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Job $job)
    {
        $form = $this->createDeleteForm($job);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($job);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('job'));
    }

    /**
     * Creates a form to delete a Job entity.
     *
     * @param Job $job The entity
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Job $job)
    {
        return $this->createFormBuilder($job)
            ->add('token', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Creates a form to publish a Job entity.
     *
     * @param Job $job The Job entity
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createPublishForm(Job $job)
    {
        return $this->createFormBuilder($job)
            ->add('token', 'hidden')
            ->getForm();
    }

    /**
     * Creates a form to extend a Job entity.
     *
     * @param Job $job The Job entity
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createExtendForm(Job $job)
    {
        return $this->createFormBuilder($job)
            ->add('token', 'hidden')
            ->getForm();
    }
}
