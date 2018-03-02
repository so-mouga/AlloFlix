<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('description',TextareaType::class)
            ->add('link', UrlType::class)
            ->add('image', UrlType::class)
            ->add('isSelected',CheckboxType::class, array(
                'required' => false))
            ->add('releaseAt',DateTimeType::class)
            ->add('saga', EntityType::class, array(
                'class'        => 'AppBundle:Saga',
                'choice_label' => 'label',
                'multiple'     => false,
                'expanded'     => true,
            ))
            ->add('categories', EntityType::class, array(
                'class'        => 'AppBundle:Category',
                'choice_label' => 'label',
                'multiple'     => true,
                'expanded'     => true,
            ))
            ->add('producers', EntityType::class, array(
                'class'        => 'AppBundle:Producer',
                'choice_label' => 'fullname',
                'multiple'     => true,
                'expanded'     => true,
            ))
            ->add('actors', EntityType::class, array(
                'class'        => 'AppBundle:Actor',
                'choice_label' => 'fullname',
                'multiple'     => true,
                'expanded'     => true,
            ))
            ->add('ajouter', SubmitType::class)
        ;

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Film'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_film';
    }


}
