<?php

namespace Gatomlo\ProjectManagerBundle\Form;

use Gatomlo\ProjectManagerBundle\Entity\Project;
use Gatomlo\ProjectManagerBundle\Entity\Tags;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('name',      TextType::class,array(
        'label'=>'Titre du projet',
        'attr' => array('class'=>'form-control')
      ))
      ->add('description',      TextareaType::class,array(
        'label'=>'Description du projet',
        'attr' => array('class'=>'form-control summernote'),
        'required' => false
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
      ))
      ->add('tags', TextType::class, array(
        'mapped'=> false,
        'attr' => array('class' => 'select-tags')
      ))

      // ->add('tags', EntityType::class, array(
      //   'class' => Tags::class,
      //   'label'=>'Projet tags',
      //   'choice_label' => 'name',
      //   'required' => false,
      //   'attr' => array('class'=>'js-select2-tags','multiple'=>'multiple'),
      //   'placeholder' => 'Ajouter des mots-clés',
      //
      // ))
      // ->add('tags',      CollectionType::class,array(
      //   'entry_type' => TagsType::class,
      //   'allow_add' => true,
      //   'allow_delete' => true,
      //   'by_reference' => false,
      //   'entry_options' => array('label' => false)
      // ))
     // ->add('tags', Select2EntityType::class, [
     //          'multiple' => true,
     //          'allow_add' => [
     //              'enabled' => true,
     //              'new_tag_text' => ' (NEW)',
     //              'new_tag_prefix' => '__',
     //              'tag_separators' => '[",", ""]'
     //          ],
     //          'class'=>Tags::class,
     //          'language' => 'fr',
     //          'allow_clear' => true,
     //          'delay' => 250,
     //          'cache' => true,
     //          'cache_timeout' => 60000, // if 'cache' is true
     //          'remote_route' => 'gatomlo_project_manager_tags_json',
     //          'minimum_input_length' => 2,
     //          'primary_key' => 'id',
     //          'text_property' => 'name',
     //          'placeholder' => 'Ajouter des tags',
     //          'page_limit'=>2
     //          // 'object_manager' => $objectManager, // inject a custom object / entity manager
     //      ])
      ->add('save',      SubmitType::class,array(
        'label'=>'Enregistrer',
        'attr' => array('class'=>'btn btn-primary')
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Gatomlo\ProjectManagerBundle\Entity\Project'
    ));
  }
}
