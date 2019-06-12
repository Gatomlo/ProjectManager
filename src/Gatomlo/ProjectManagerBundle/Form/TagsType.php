<?php

namespace Gatomlo\ProjectManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gatomlo\ProjectManagerBundle\Entity\Tags;

class TagsType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('name',TextType::class,array(
      ))
      ->add('type', ChoiceType::class, array(
        'choices'  => [
        'contact' => 0,
        'tâche' => 1,
        'événement' => 2,
        'projet' => 3,
        'rapport' => 4
        ],
      ))
      ->add('save',      SubmitType::class,array(
        'label'=>'Enregistrer',
        'attr' => array('class'=>'btn btn-primary')
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Gatomlo\ProjectManagerBundle\Entity\Tags'
    ));
  }
}
