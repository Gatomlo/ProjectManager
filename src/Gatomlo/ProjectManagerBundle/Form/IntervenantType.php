<?php

namespace Gatomlo\ProjectManagerBundle\Form;
use Gatomlo\ProjectManagerBundle\Entity\People;
use Gatomlo\ProjectManagerBundle\Entity\Job;
use Gatomlo\ProjectManagerBundle\Entity\Project;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class IntervenantType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('people', EntityType::class, array(
      'class' => People::class,
      'label'=>'Nom',
      'choice_label' => 'identity',
      'required' => true,
      'attr' => array('class'=>'select-people'),
      'placeholder' => 'Sélectionner un intervenant',
      'data' => $options['people'],
    ))
    ->add('job', EntityType::class, array(
      'class' => Job::class,
      'label'=>'Fonction',
      'choice_label' => 'name',
      'required' => true,
      'attr' => array('class'=>'select-function'),
      'placeholder' => 'Sélectionner une fonction',
    ))
    ->add('project', EntityType::class, array(
      'class' => Project::class,
      'label'=>'Nom',
      'choice_label' => 'name',
      'required' => true,
      'attr' => array('class'=>'select-project'),
      'placeholder' => 'Sélectionner un projet',
      'data' => $options['project'],

    ))
    ->add('comment', TextareaType::class,array(
      'label'=>'Commentaire',
      'attr' => array('class'=>'form-control summernote'),
      'required' => false
    ))
    ->add('save',      SubmitType::class,array(
      'label'=>'Enregistrer',
      'attr' => array('class'=>'btn btn-primary')
    ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Gatomlo\ProjectManagerBundle\Entity\Intervenant',
      'project' => '',
      'people' => '',
    ));
  }
}
