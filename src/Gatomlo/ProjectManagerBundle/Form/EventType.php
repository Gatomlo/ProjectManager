<?php

namespace Gatomlo\ProjectManagerBundle\Form;

use Gatomlo\ProjectManagerBundle\Entity\Event;
use Gatomlo\ProjectManagerBundle\Entity\Type;
use Gatomlo\ProjectManagerBundle\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gatomlo\ProjectManagerBundle\Repository\ProjectRepository;

class EventType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $user = $options['curentUser'];
    $builder
      ->add('title',      TextType::class,array(
        'label'=>'Titre',
        'attr' => array('class'=>'form-control'),
        'required' => true
      ))
      ->add('type', EntityType::class, array(
        'class' => Type::class,
        'label'=>'Type d\'événement',
        'choice_label' => 'name',
        'required' => true,
        'placeholder' => 'Choisir un type',
      ))
      ->add('description',      TextareaType::class,array(
        'label'=>'Détail',
        'attr' => array('class'=>'form-control summernote'),
        'required' => true
      ))
      ->add('startdate',      DatetimeType::class,array(
        'label'=>'Début de l\'événement',
        'widget' => 'single_text',
        'required' => true,
        'html5' => false,
        'attr' => array('class'=>'datetimepicker'),
      ))
      ->add('enddate',      DatetimeType::class,array(
        'label'=>'Fin de l\'événement',
        'widget' => 'single_text',
        'required' => false,
        'html5' => false,
        'attr' => array('class'=>'datetimepicker'),
      ))
      ->add('project', EntityType::class, array(
        'class' => Project::class,
        'label'=>'Projet lié',
        'choice_label' => 'name',
        'required' => true,
        'placeholder' => 'Choisir un projet',
        'attr' => array('class'=>'select-project'),
        'data' => $options['project'],
        'query_builder' => function(ProjectRepository $er) use ($user)
               {
                  return $er->getOwnerProjectsForList($user);
               },
      ))
      ->add('tagsArray', TextType::class, array(
        'label'=>'Tags',
        'mapped'=> false,
        'attr' => array('class' => 'select-tags'),
        'data' => $options['existingTags'],
        'required' => false,
      ))
      ->add('save',      SubmitType::class,array(
        'label'=>'Enregistrer',
        'attr' => array('class'=>'btn btn-primary')
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Gatomlo\ProjectManagerBundle\Entity\Event',
      'project' => '',
      'existingTags' => ''
    ));
    $resolver->setRequired(['curentUser']);
  }
}
