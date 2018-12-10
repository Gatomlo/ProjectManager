<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Project;
use Gatomlo\ProjectManagerBundle\Entity\Tags;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Gatomlo\ProjectManagerBundle\Form\ProjectType;
use Symfony\Component\HttpFoundation\JsonResponse;



class ProjectController extends Controller
{
  public function allAction($archived)
  {
      $em = $this->getDoctrine()->getManager();
      $projects = $em->getRepository('GatomloProjectManagerBundle:Project')->findBy(array(
        'archived'=> $archived
      ));
      return $this->render('@GatomloProjectManager/Project/project.all.html.twig',array('projects'=>$projects, 'archived'=>$archived));
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

  public function jsonProjectsListAction()
  {
      $em = $this->getDoctrine()->getManager();
      $projects = $em->getRepository('GatomloProjectManagerBundle:Project')->findAll();

      $list_Projects = array();
      foreach ($projects as $project){
          $obj['id'] = $project->getId();
          $obj['text'] = $project->getName();
          array_push($list_Projects,$obj);
      }
      return new JsonResponse($list_Projects);
  }

  public function addAction(Request $request)
  {
    // On crée un objet Project
    $project = new Project();

    $form = $this->get('form.factory')->create(ProjectType::class, $project);

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
       $tag = new Tags();
       $tag->setName('ProjectController');
       $project->addTag($tag);
       $em->persist($project);
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Projet bien enregistrée.');

       // On redirige vers la page de visualisation de l'annonce nouvellement créée
       return $this->redirectToRoute('gatomlo_project_manager_one_project', array('id' => $project->getId()));
     }
   }


    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('@GatomloProjectManager/Project/project.add.html.twig', array(
      'form' => $form->createView(),
      'project'=>$project
    ));
  }

  public function editAction(Request $request, $id)
  {
    // On crée un objet Project
    $em = $this->getDoctrine()->getManager();
    $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find($id);

    $form = $this->get('form.factory')->create(ProjectType::class, $project);

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
      'project'=>$project
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

  public function archivedAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find($id);

    if ($project->getArchived()== FALSE){
      $project->SetArchived(TRUE);
    }
    else{
      $project->SetArchived(FALSE);
    }

    $em->persist($project);
    $em->flush();
    if ($project->getArchived()== TRUE){
      return $this->redirectToRoute('gatomlo_project_manager_all_projects');
    }
    else{
      return $this->redirectToRoute('gatomlo_project_manager_all_projects',array('archived'=>1));
    }

  }
}
