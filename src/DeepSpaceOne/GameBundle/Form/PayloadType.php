<?php

namespace DeepSpaceOne\GameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PayloadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mass', null, array('error_bubbling' => true))
            ->add('good', null, array('error_bubbling' => true))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DeepSpaceOne\GameBundle\Entity\Payload',
            'error_bubbling' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'deepspaceone_payload';
    }
}
