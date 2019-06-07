<?php

namespace Gatomlo\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('username',      TextType::class,array(
        'label'=>'Nom d\'utilisateur',
        'attr' => array('class'=>'form-control'),
      ))
      ->add('password',      TextType::class,array(
        'label'=>'Nouveau mot de passe',
        'attr' => array('class'=>'form-control'),
        'required' => false,
        'data'=>''

      ))
      ->add('email',      TextType::class,array(
        'label'=>'Email',
        'attr' => array('class'=>'form-control'),
        'required' => false
      ))
      ->add('enabled', CheckboxType::class, array(
        'label'    => 'Compte activé',
        'required' => false,
      ))
      ->add('admin', CheckboxType::class, array(
        'label'    => 'Compte admin',
        'required' => false,
        'mapped' => False,
        'data' => $options['isAdmin'],
      ))
      ->add('save',      SubmitType::class,array(
        'label'=>'Enregistrer',
        'attr' => array('class'=>'btn btn-primary')
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Gatomlo\UserBundle\Entity\User',
      'isAdmin' => 'false'
    ));
  }
}
