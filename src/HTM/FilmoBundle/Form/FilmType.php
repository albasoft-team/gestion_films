<?php

namespace HTM\FilmoBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('description',TextareaType::class, array('attr' => array('class' => 'form-control')))
            ->add('categorie',EntityType::class, array(
                // query choices from this entity
                'class' => 'HTMFilmoBundle:Categorie',
                'choice_label' => 'nom',
                'attr' => array('class' => 'form-control')
            ))
            ->add('acteur', EntityType::class, array(
                // query choices from this entity
                'class' => 'HTMFilmoBundle:Acteur',
                'choice_label' => 'prenom',
                'multiple' => true,
                'attr' => array('class' => 'form-control')
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HTM\FilmoBundle\Entity\Film'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'htm_filmobundle_film';
    }


}
