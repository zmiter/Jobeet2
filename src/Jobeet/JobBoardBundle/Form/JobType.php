<?php

namespace Jobeet\JobBoardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', array(
                'choices' => array(
                    'full-time' => 'Full time',
                    'part-time' => 'Part time',
                    'freelance' => 'Freelance'
                ),
                'required' => false
            ))
            ->add('company')
            ->add('logoFile')
            ->add('url')
            ->add('position')
            ->add('location')
            ->add('description')
            ->add('howToApply')
            ->add('token')
            ->add('isPublic')
            ->add('email')
            ->add('category', null, array('property' => 'name'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jobeet\JobBoardBundle\Entity\Job'
        ));
    }

    public function getName()
    {
        return 'jobeet_jobboardbundle_jobtype';
    }
}
