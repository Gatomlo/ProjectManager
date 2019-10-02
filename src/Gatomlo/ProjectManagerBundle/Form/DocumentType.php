<?php

namespace Gatomlo\ProjectManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Gatomlo\ProjectManagerBundle\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Gatomlo\ProjectManagerBundle\Repository\ProjectRepository;

class DocumentType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $user = $options['curentUser'];
    $builder
      ->add('documentFile', VichFileType::class, array(
        'label'=>'Document',
        'required' => false,
      ))
      ->add('project', EntityType::class, array(
        'class' => Project::class,
        'label'=>'Lier au projet',
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
      ->add('save',      SubmitType::class,array(
        'label'=>'Enregistrer',
        'attr' => array('class'=>'btn btn-primary')
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Gatomlo\ProjectManagerBundle\Entity\Document',
      'project' => '',
    ));
    $resolver->setRequired(['curentUser']);
  }
}
