<?php

namespace HTM\FilmoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActeurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Nom')))
                ->add('prenom', TextType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Prenom')))
                ->add('datenaissance', DateType::class,array(
                    'widget' => 'single_text',
                    'html5' => false,
                    'format' => 'dd-MM-yyyy',
                    'attr' => array('class' => 'form-control','placeholder' => 'dd-mm-yyyy')
                ))
                ->add('sexe',ChoiceType::class,  array('attr' => array('class' => 'form-control'),'choices' => array('M' => 'Masculin', 'F' => 'Feminin'),));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HTM\FilmoBundle\Entity\Acteur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'htm_filmobundle_acteur';
    }


}
