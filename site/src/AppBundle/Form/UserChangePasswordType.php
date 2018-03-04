<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserChangePasswordType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('create')
            ->remove('email')
            ->remove('pseudo')
            ->add('confirmNewPassword' , PasswordType::class , array('attr' => ['placeholder' => 'Confirmation du nouveau mot de passe'] , 'mapped' => false , 'label' => 'Confirmation du nouveau mot de passe'))
            ->add('newPassword' , PasswordType::class , array('attr' => ['placeholder' => ' Nouveau mot de passe'] , 'mapped' => false , 'label' => 'Mot de passe actuel'))
            ->add('changePassword', SubmitType::class, array(
                'label' =>'Mettre à jour'));
        
    }

    public function getName()
    {
        return 'alloflix_form_change_password';
    }
    
    
    public function getParent()
    {
        return UserType::class;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }


}
