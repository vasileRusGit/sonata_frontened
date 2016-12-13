<?php

namespace Yoda\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Yoda\EventBundle\Entity\Event;

class EventType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productName', 'text', array('label' => false))
            ->add('carMark', 'text', array('label' => false))
            ->add('carModel', 'text', array('label' => false))
            ->add('carYear', 'text', array('label' => false))
            ->add('stock', 'text', array('label' => false))
            ->add('details', 'text', array('label' => false))
            ->add('files', 'file', array('label' => false,
//                            'multiple' => 'multiple',
                'data_class' => null))
            ->add('submit','submit', array('label' => 'submit', 'attr' => array('class' => 'btn btn-primary', 'style' => 'float:right')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yoda\EventBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'yoda_eventbundle_event';
    }

}
