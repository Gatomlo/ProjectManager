<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Project;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ProjectController extends Controller
{
  public function allAction()
  {
      $em = $this->getDoctrine()->getManager();
      $projects = $em->getRepository('GatomloProjectManagerBundle:Project')->findAll();
      return $this->render('@GatomloProjectManager/Project/project.all.html.twig',array('projects'=>$projects));
  }
  public function viewAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find($id);

      if (null === $project) {
        throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
      }


      return $this->render('@GatomloProjectManager/Project/project.view.html.twig',array(
        'project'=>$project));
  }
  public function addAction(Request $request)
  {
    // On crée un objet Project
    $project = new Project();

    // On crée le FormBuilder grâce au service form factory
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $project);

    // On ajoute les champs de l'entité que l'on veut à notre formulaire
    $formBuilder
      ->add('name',      TextType::class)
      ->add('description', TextareaType::class)
      ->add('parent', EntityType::class, array(
        'class' => Project::class,
        'choice_label' => 'name'))
      ->add('save',      SubmitType::class)
    ;

    // À partir du formBuilder, on génère le formulaire
    $form = $formBuilder->getForm();

    // Si la requête est en POST
   if ($request->isMethod('POST')) {
     // On fait le lien Requête <-> Formulaire
     // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
     $form->handleRequest($request);

     // On vérifie que les valeurs entrées sont correctes
     // (Nous verrons la validation des objets en détail dans le prochain chapitre)
     if ($form->isValid()) {
       // On enregistre notre objet $advert dans la base de données, par exemple
       $em = $this->getDoctrine()->getManager();
       $em->persist($project);
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

       // On redirige vers la page de visualisation de l'annonce nouvellement créée
       return $this->redirectToRoute('gatomlo_project_manager_one_project', array('id' => $project->getId()));
     }
   }


    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('@GatomloProjectManager/Project/project.add.html.twig', array(
      'form' => $form->createView(),
    ));
  }

  public function editAction(Request $request, $id)
  {
    // On crée un objet Project
    $em = $this->getDoctrine()->getManager();
    $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find($id);

    // On crée le FormBuilder grâce au service form factory
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $project);

    // On ajoute les champs de l'entité que l'on veut à notre formulaire
    $formBuilder
      ->add('name',      TextType::class)
      ->add('description', TextareaType::class)
      ->add('parent', EntityType::class, array(
        'class' => Project::class,
        'choice_label' => 'name'))
      ->add('save',      SubmitType::class)
    ;

    // À partir du formBuilder, on génère le formulaire
    $form = $formBuilder->getForm();

    // Si la requête est en POST
   if ($request->isMethod('POST')) {
     // On fait le lien Requête <-> Formulaire
     // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
     $form->handleRequest($request);

     // On vérifie que les valeurs entrées sont correctes
     // (Nous verrons la validation des objets en détail dans le prochain chapitre)
     if ($form->isValid()) {
       // On enregistre notre objet $advert dans la base de données, par exemple
       $em = $this->getDoctrine()->getManager();
       $em->persist($project);
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

       // On redirige vers la page de visualisation de l'annonce nouvellement créée
       return $this->redirectToRoute('gatomlo_project_manager_one_project', array('id' => $project->getId()));
     }
   }


    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('@GatomloProjectManager/Project/project.add.html.twig', array(
      'form' => $form->createView(),
    ));
  }

  public function deleteAction($id)
  {
      $em = $this->getDoctrine()->getManager();
      $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find($id);
      $em->remove($project);
      $em->flush();

       return $this->redirectToRoute('gatomlo_project_manager_all_projects');
  }

  public function addParentAction($idChild,$idParent)
  {
      $em = $this->getDoctrine()->getManager();
      $child = $em->getRepository('GatomloProjectManagerBundle:Project')->find($idChild);
      $parent = $em->getRepository('GatomloProjectManagerBundle:Project')->find($idParent);

      $parent->addChild($child);
      $child->setParent($parent);

      $em->persist($child);
      $em->persist($parent);
      $em->flush();

      return $this->render('@GatomloProjectManager/Project/project.default.html.twig',array(
        'child'=>$child,
        'parent'=>$parent));
  }
}
