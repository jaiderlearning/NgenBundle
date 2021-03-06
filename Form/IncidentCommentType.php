<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of IncidentCommentType
 *
 * @author dam
 */
class IncidentCommentType extends AbstractType
{

    private $commentClass;

    public function __construct($commentClass)
    {
        $this->commentClass = $commentClass;
    }

    /**
     * Configures a Comment form.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('body', TextareaType::class)
            ->add('notify_to_admin', CheckboxType::class, array('data' => false, 'mapped' => true, 'attr' => array(), 'required' => false, 'label' => 'Notify to admin'));
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->commentClass,
        ));
    }

    public function getName()
    {
        return "fos_comment_comment";
    }

//    public function getParent() {
//        return "fos_comment_comment";
//    }
}
