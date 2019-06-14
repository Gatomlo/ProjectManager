<?php

namespace Gatomlo\ProjectManagerBundle\Form;

use Doctrine\ORM\EntityRepository;
use Gatomlo\ProjectManagerBundle\Entity\Project;
use Gatomlo\ProjectManagerBundle\Entity\Tags;
use Gatomlo\ProjectManagerBundle\Entity\Status;
use Gatomlo\UserBundle\Entity\User;
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
use Gatomlo\ProjectManagerBundle\Repository\ProjectRepository;


class ProjectType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $user = $options['curentUser'];
    $builder
      ->add('name',      TextType::class,array(
        'label'=>'Titre du projet',
        'attr' => array('class'=>'form-control')
      ))
      ->add('matricule',      TextType::class,array(
        'label'=>'Numéro de référence',
        'attr' => array('class'=>'form-control'),
        'required' => false
      ))
      ->add('description',      TextareaType::class,array(
        'label'=>'Description du projet',
        'attr' => array('class'=>'form-control summernote'),
        'required' => false
      ))
      ->add('status', EntityType::class, array(
        'class' => Status::class,
        'label'=>'Status du projet',
        'choice_label' => 'name',
        'required' => false,
        'attr' => array('class'=>'select-parent'),
        'placeholder' => 'Sélectionner un status',
      ))
      ->add('url',      TextType::class,array(
        'label'=>'URL du projet',
        'attr' => array('class'=>'form-control'),
        'required' => false
      ))
      ->add('endtime',      DatetimeType::class,array(
        'label'=>'Date d\'échéance',
        'widget' => 'single_text',
        'html5'=> false,
        'attr' => array('class'=>'datetimepicker'),
        'required' => false,
      ))
      ->add('parent', EntityType::class, array(
        'class' => Project::class,
        'label'=>'Projet parent',
        'choice_label' => 'name',
        'required' => false,
        'attr' => array('class'=>'select-parent'),
        'placeholder' => 'Sélectionner un parent',
        'query_builder' => function(ProjectRepository $er) use ($user)
               {
                  return $er->getOwnerProjectsForList($user);
               },
      ))
      ->add('owner', TextType::class, array(
        'label'=>'Autres gestionnaires du projet',
        'mapped'=> false,
        'required' => false,
        'attr' => array('class'=>'select-user'),
        'data' => $options['actualOwners'],
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
    $resolver
    ->setDefaults(array(
      'data_class' => 'Gatomlo\ProjectManagerBundle\Entity\Project',
      'existingTags' => '',
      'actualOwners' => '',
    ));
    $resolver->setRequired(['curentUser']);
  }
}
