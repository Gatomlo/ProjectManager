<?php

namespace Gatomlo\ProjectManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatusType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('name',TextType::class,array(
        'label'=>'Nom du status',
      ))
      ->add('description', TextareaType::class,array(
        'label'=>'Description du status',
        'attr' => array('class'=>'form-control summernote'),
      ))
      ->add('save',      SubmitType::class,array(
        'label'=>'Enregistrer',
        'attr' => array('class'=>'btn btn-primary')
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Gatomlo\ProjectManagerBundle\Entity\Status'
    ));
  }
}
