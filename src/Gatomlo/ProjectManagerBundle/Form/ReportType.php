<?php

namespace Gatomlo\ProjectManagerBundle\Form;

use Gatomlo\ProjectManagerBundle\Entity\Project;
use Gatomlo\ProjectManagerBundle\Entity\Report;
use Gatomlo\ProjectManagerBundle\Entity\People;
use Gatomlo\ProjectManagerBundle\Entity\Type;
use Gatomlo\ProjectManagerBundle\Entity\Tags;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class ReportType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {

    $builder
      ->add('name',      TextType::class,array(
        'label'=>'Titre du rapport',
        'attr' => array('class'=>'form-control')
      ))
      ->add('startDate',      DatetimeType::class,array(
        'label'=>'Date de début',
        'widget' => 'single_text',
        'html5'=> false,
        'attr' => array('class'=>'datetimepicker'),
        'required' => false,
      ))
      ->add('endDate',      DatetimeType::class,array(
        'label'=>'Date de fin',
        'widget' => 'single_text',
        'html5'=> false,
        'attr' => array('class'=>'datetimepicker'),
        'required' => false,
      ))
      ->add('project', EntityType::class, array(
        'class' => Project::class,
        'label'=>'Projet',
        'choice_label' => 'name',
        'required' => false,
        'attr' => array('class'=>'select-parent'),
        'placeholder' => 'Sélectionner un projet',
      ))
      ->add('type', EntityType::class, array(
        'class' => Type::class,
        'label'=>'Type d\'événement',
        'choice_label' => 'name',
        'required' => false,
        'attr' => array('class'=>'select-parent'),
        'placeholder' => 'Sélectionner un type',
      ))
      ->add('intervenant', EntityType::class, array(
        'class' => People::class,
        'label'=>'Intervenant',
        'choice_label' => 'identity',
        'required' => false,
        'attr' => array('class'=>'select-parent'),
        'placeholder' => 'Sélectionner un intervenant',
      ))
      ->add('tagsArray', TextType::class, array(
        'label'=>'Tags',
        'mapped'=> false,
        'required'=>false,
        'attr' => array('class' => 'select-tags'),
        'data' => $options['existingTags'],
      ))
      ->add('save',      SubmitType::class,array(
        'label'=>'Enregistrer',
        'attr' => array('class'=>'btn btn-primary')
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Gatomlo\ProjectManagerBundle\Entity\Report',
      'existingTags' => ''
    ));
  }
}
