<?php

namespace Gatomlo\ProjectManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeopleType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('firstName',      TextType::class,array(
        'label'=>'Prénom',
        'attr' => array('class'=>'form-control'),
      ))
      ->add('lastName',      TextType::class,array(
        'label'=>'Nom',
        'attr' => array('class'=>'form-control')
      ))
      ->add('email',      TextType::class,array(
        'label'=>'Email',
        'attr' => array('class'=>'form-control'),
        'required' => false
      ))
      ->add('phone',      TextType::class,array(
        'label'=>'Téléphone',
        'attr' => array('class'=>'form-control'),
        'required' => false
      ))
      ->add('streetAndNumer',      TextType::class,array(
        'label'=>'Rue + numéro',
        'attr' => array('class'=>'form-control'),
        'required' => false
      ))
      ->add('cityAndCode',      TextType::class,array(
        'label'=>'Code postal + Ville',
        'attr' => array('class'=>'form-control'),
        'required' => false
      ))
      ->add('institution',      TextType::class,array(
        'label'=>'Nom de l\'institution',
        'attr' => array('class'=>'form-control'),
        'required' => false
      ))
      ->add('streetOfInstitution',      TextType::class,array(
        'label'=>'Rue + numéro',
        'attr' => array('class'=>'form-control'),
        'required' => false
      ))
      ->add('cityAndCodeOfInstitution',      TextType::class,array(
        'label'=>'Code postal + ville',
        'attr' => array('class'=>'form-control'),
        'required' => false
      ))
      ->add('fonction',      TextType::class,array(
        'label'=>'Fonction',
        'attr' => array('class'=>'form-control'),
        'required' => false
      ))
      ->add('diplome',      TextType::class,array(
        'label'=>'Diplôme',
        'attr' => array('class'=>'form-control'),
        'required' => false
      ))
      ->add('matricule',      TextType::class,array(
        'label'=>'Matricule',
        'attr' => array('class'=>'form-control'),
        'required' => false
      ))
      ->add('comment',      TextareaType::class,array(
        'label'=>'Commentaire',
        'attr' => array('class'=>'form-control summernote'),
        'required' => false
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
      'data_class' => 'Gatomlo\ProjectManagerBundle\Entity\People',
      'existingTags' => ''
    ));
  }
}
